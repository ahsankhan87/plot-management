<?php

namespace App\Controllers;

use App\Models\InstallmentModel;
use App\Models\InstallmentPlansModel;
use App\Models\PaymentModel;
use App\Models\PlotsModel;
use App\Models\ApplicationsModel;
use CodeIgniter\Controller;

class Installments extends Controller
{
    protected $installmentModel;
    protected $paymentModel;
    protected $applicationModel;
    protected $plotModel;
    protected $installmentPlansModel;

    public function __construct()
    {
        $this->installmentModel = new InstallmentModel();
        $this->paymentModel = new PaymentModel();
        $this->applicationModel = new ApplicationsModel();
        $this->plotModel = new PlotsModel();
        $this->installmentPlansModel = new InstallmentPlansModel();
        //$this->checkOverdue();
        helper('audit');
        helper('auth');
    }

    // Show all installments
    public function index()
    {
        if (!auth()->user()->can('installments_view')) {
            return view('errors/no_access');
        }
        $data['title'] = 'Installments';
        $data['installments'] = $this->installmentModel
            ->select('installments.*, customers.name as customer_name')
            ->join('applications', 'applications.id=installments.application_id')
            ->join('customers', 'customers.id=applications.customer_id')
            ->join('payments', 'payments.installment_id=installments.id', 'left')
            ->findAll();
        return view('installments/index', $data);
    }
    public function show($applicationId)
    {
        if (!auth()->user()->can('installments_view')) {
            return view('errors/no_access');
        }
        $data['title'] = 'Installment Details';
        $data['installments'] = $this->installmentModel
            ->select('installments.*, customers.name as customer_name')
            ->join('applications', 'applications.id=installments.application_id')
            ->join('customers', 'customers.id=applications.customer_id')
            ->join('payments', 'payments.installment_id=installments.id', 'left')
            ->where('installments.application_id', $applicationId)
            ->findAll();
        return view('installments/index', $data);
    }

    // Generate installments (example: 9 years = 108 months)
    public function generate($applicationId)
    {
        if (!auth()->user()->can('installments_create')) {
            return view('errors/no_access');
        }
        //check installment first
        $existingInstallments = $this->installmentModel
            ->where('application_id', $applicationId)
            ->where('head', 'Installment')
            ->findAll();

        if (!empty($existingInstallments)) {
            return redirect()->back()->with('error', 'Installments already exist for this application');
        }

        $app = $this->applicationModel->find($applicationId);
        $plot = $this->plotModel->find($app['plot_id']);
        $installmentPlan = $this->installmentPlansModel->find($app['installment_plan_id']);
        $tenure_months = $installmentPlan['tenure_months']; // in months

        $plotTotalAmount = $plot['base_price'];
        $bookingAmount = $app['booking_amount'];
        //check amounts
        if ($bookingAmount > $plotTotalAmount) {
            return redirect()->back()->with('error', 'Booking amount exceeds plot total amount');
        }
        $remainingAmount = $plotTotalAmount - $bookingAmount;
        $amount = $remainingAmount / $tenure_months;
        $startDate = date('Y-m-d');

        for ($i = 1; $i <= $tenure_months; $i++) {
            $dueDate = date('Y-m-d', strtotime("+$i month", strtotime($startDate)));
            $this->installmentModel->insert([
                'application_id' => $applicationId,
                'installment_no' => $i,
                'due_date' => $dueDate,
                'amount' => $amount,
                'head' => 'Installment'
            ]);
        }
        // Log the audit
        logAudit('CREATE', 'Installments, App ID', $applicationId, [], ['App No' => $app['app_no'], 'Plot Id' => $app['plot_id'], 'Installment Plan' => $installmentPlan['name'], 'Total Amount' => $plotTotalAmount, 'Booking Amount' => $bookingAmount, 'Tenure Months' => $tenure_months]);
        return redirect()->to('/applications/detail/' . $applicationId)->with('success', 'Installments generated');
    }

    // Mark installment as paid
    public function pay($id)
    {
        if (!auth()->user()->can('payments_create')) {
            return view('errors/no_access');
        }

        $installment = $this->installmentModel->find($id);
        if (!$installment) {
            return redirect()->back()->with('error', 'Installment not found');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Check if installment is already paid
            if ($installment['status'] == 'paid') {
                $db->transRollback();
                return redirect()->back()->with('error', 'Installment already paid');
            }

            $this->installmentModel->update($id, [
                'status' => 'paid'
            ]);

            $paymentData = [
                'installment_id' => $id,
                'application_id' => $installment['application_id'],
                'paid_amount' => $installment['amount'],
                'payment_date' => date('Y-m-d'),
                'payment_method' => 'cash',
                'transaction_ref' => method_exists($this->paymentModel, 'generateTransactionRef') ? $this->paymentModel->generateTransactionRef() : uniqid(),
                'received_by' => session()->get('user_id'),
                'remarks' => ''
            ];

            $insertResult = $this->paymentModel->insert($paymentData);

            if ($insertResult === false) {
                $db->transRollback();
                $errors = $this->paymentModel->errors();
                return redirect()->back()->with('error', 'Payment insert failed: ' . implode(', ', $errors));
            }

            //log audit
            logAudit('PAY', 'Installments ID', $id, $installment, $paymentData);

            $db->transComplete();

            if ($db->transStatus() === false) {
                return redirect()->back()->with('error', 'Payment failed due to transaction error.');
            }

            return redirect()->to('/applications/detail/' . $installment['application_id'])->with('success', 'Payment recorded');
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }
    public function payCustomAmount($appId)
    {
        if (!auth()->user()->can('payments_create')) {
            return view('errors/no_access');
        }

        $amount = $this->request->getPost('amount');
        $remarks = $this->request->getPost('remarks');
        $paymentMethod = $this->request->getPost('payment_method');
        $paymentDate = $this->request->getPost('payment_date');
        $transaction_ref = $this->request->getPost('transaction_ref');

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Fetch unpaid installments sorted by due date
            $installments = $this->installmentModel->getUnpaidInstallments($appId);

            $remaining = $amount;

            foreach ($installments as $row) {
                if ($remaining <= 0) break;

                if ($remaining >= $row['amount']) {
                    // Full installment paid
                    $this->installmentModel->update($row['id'], ['status' => 'paid']);
                    $insertResult = $this->paymentModel->insert([
                        'installment_id' => $row['id'],
                        'application_id' => $appId,
                        'payment_date'   => $paymentDate,
                        'paid_amount'    => $row['amount'],
                        'payment_method' => $paymentMethod,
                        'transaction_ref' => $transaction_ref,
                        'received_by'    => session()->get('user_id'),
                        'remarks'        => $remarks,
                    ]);
                    if ($insertResult === false) {
                        $db->transRollback();
                        $errors = $this->paymentModel->errors();
                        return redirect()->back()->with('error', 'Payment insert failed: ' . implode(', ', $errors));
                    }
                    $remaining -= $row['amount'];
                } else {
                    // Partial installment
                    $insertResult = $this->paymentModel->insert([
                        'installment_id' => $row['id'],
                        'application_id' => $appId,
                        'payment_date'   => $paymentDate,
                        'paid_amount'    => $remaining,
                        'payment_method' => $paymentMethod,
                        'transaction_ref' => $transaction_ref,
                        'received_by'    => session()->get('user_id'),
                        'remarks'        => $remarks,
                    ]);
                    if ($insertResult === false) {
                        $db->transRollback();
                        $errors = $this->paymentModel->errors();
                        return redirect()->back()->with('error', 'Payment insert failed: ' . implode(', ', $errors));
                    }
                    $remaining = 0;
                }
            }
            // log audit
            logAudit('PAY', 'Installments, App ID', $appId, [], $this->request->getPost());
            $db->transComplete();

            if ($db->transStatus() === false) {
                return redirect()->back()->with('error', 'Payment failed due to transaction error.');
            }

            return redirect()->back()->with('success', 'Payment applied successfully.');
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }

    public function payFullRemaining($appId)
    {
        if (!auth()->user()->can('payments_create')) {
            return view('errors/no_access');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $installments = $this->installmentModel->getUnpaidInstallments($appId);
            $totalAmount = array_sum(array_column($installments, 'amount'));

            if (empty($installments)) {
                $db->transRollback();
                return redirect()->back()->with('error', 'No unpaid installments found for this application.');
            }

            foreach ($installments as $row) {
                // Mark all unpaid installments as paid
                $this->installmentModel->update($row['id'], ['status' => 'paid']);
                $insertResult = $this->paymentModel->insert([
                    'installment_id' => $row['id'],
                    'application_id' => $appId,
                    'payment_date'   => date('Y-m-d'),
                    'paid_amount'    => $row['amount'],
                    'payment_method' => 'cash',
                    'transaction_ref' => method_exists($this->paymentModel, 'generateTransactionRef') ? $this->paymentModel->generateTransactionRef() : uniqid(),
                    'received_by'    => session()->get('user_id'),
                    'remarks'        => 'Full payment for installment ' . $row['installment_no'],
                ]);

                if ($insertResult === false) {
                    $db->transRollback();
                    $errors = $this->paymentModel->errors();
                    return redirect()->back()->with('error', 'Payment insert failed: ' . implode(', ', $errors));
                }
            }

            // Update application status to Completed
            $this->applicationModel->update($appId, [
                'status'     => 'Completed',
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            //update plot status to allotted
            $application = $this->applicationModel->find($appId);
            $insertResult = $this->plotModel->update($application['plot_id'], ['status' => 'Allotted']);
            if ($insertResult === false) {
                $db->transRollback();
                $errors = $this->plotModel->errors();
                return redirect()->back()->with('error', 'Plot update failed: ' . implode(', ', $errors));
            }

            //log audit
            logAudit('PAYFULL', 'Installments, App ID', $appId, [], ['Total Amount' => $totalAmount]);

            $db->transComplete();

            if ($db->transStatus() === false) {
                return redirect()->back()->with('error', 'Payment failed due to transaction error.');
            }

            return redirect()->back()->with('success', 'Full payment received. Application completed.');
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }

    // Overdue check (cron job / manual run)
    public function checkOverdue()
    {
        $today = date('Y-m-d');
        $installments = $this->installmentModel->where('status', 'pending')->findAll();
        foreach ($installments as $ins) {
            $dueDate = new \DateTime($ins['due_date']);
            $now = new \DateTime($today);
            $diff = $dueDate->diff($now)->m + ($dueDate->diff($now)->y * 12);
            if ($diff > 3) {
                $this->installmentModel->update($ins['id'], ['status' => 'overdue']);
            }
        }
    }
    public function store()
    {
        if (!auth()->user()->can('installments_create')) {
            return view('errors/no_access');
        }
        $data = $this->request->getPost();
        //$this->installmentModel->save([...]);
        logAudit('CREATE', 'Installments', $this->installmentModel->insertID(), [], $this->request->getPost());
        return redirect()->to('/installments')->with('success', 'Installment created successfully');
    }
    public function update($id)
    {
        if (!auth()->user()->can('installments_update')) {
            return view('errors/no_access');
        }
        $data = $this->request->getPost();
        //$this->installmentModel->update($id, [...]);
        logAudit('UPDATE', 'Installments', $id, $this->installmentModel->find($id), $this->request->getPost());
        return redirect()->to('/installments')->with('success', 'Installment updated successfully');
    }
    public function delete($id)
    {
        if (!auth()->user()->can('installments_delete')) {
            return view('errors/no_access');
        }
        $installment = $this->installmentModel->find($id);
        if (!$installment) {
            return redirect()->back()->with('error', 'Installment not found');
        }
        logAudit('DELETE', 'Installments', $id, $this->installmentModel->find($id), []);
        $this->installmentModel->delete($id);
        return redirect()->to('/installments')->with('success', 'Installment deleted successfully');
    }
}

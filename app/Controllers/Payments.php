<?php

namespace App\Controllers;

use App\Models\InstallmentModel;
use App\Models\PaymentModel;
use App\Models\ApplicationsModel; // your applications table
use app\Models\CompanyModel;

class Payments extends BaseController
{
    protected $installmentModel;
    protected $paymentModel;
    protected $applicationModel;

    public function __construct()
    {
        $this->installmentModel = new InstallmentModel();
        $this->paymentModel = new PaymentModel();
        $this->applicationModel = new ApplicationsModel();
        helper('form');
        helper('auth');
        helper('audit');
    }

    // List installments of an application
    public function index($application_id)
    {
        if (!auth()->user()->can('payments_view')) {
            return view('errors/no_access');
        }

        $data['installments'] = $this->installmentModel->getByApplication($application_id);
        $data['application_id'] = $application_id;


        return view('payments/index', $data);
    }
    public function getOverduePayments()
    {
        if (!auth()->user()->can('payments_view')) {
            return view('errors/no_access');
        }

        $data['overdue_payments'] = $this->paymentModel->getOverduePayments();

        return view('payments/overdue', $data);
    }

    public function record($application_id)
    {
        if (!auth()->user()->can('payments_create')) {
            return view('errors/no_access');
        }

        $application = $this->applicationModel->getApplicationDetail($application_id);

        if (!$application) {
            return redirect()->to('/applications')->with('error', 'Application not found');
        }

        $data = [
            'application' => $application,
            'referenceNo' => $this->paymentModel->generateTransactionRef(),
            'payments' => $this->paymentModel->getPaymentsByApplication($application_id),
            'totalPaid' => $this->paymentModel->getTotalPaid($application_id),
            'validation' => \Config\Services::validation()
        ];

        return view('payments/record', $data);
    }

    // Generate payment receipt
    public function receipt($paymentId)
    {
        $payment = $this->paymentModel->find($paymentId);
        if (!$payment) {
            return redirect()->back()->with('error', 'Payment not found');
        }

        $companyModel = new CompanyModel();

        $data = [
            'payment' => $payment,
            'booking' => $this->applicationModel->getApplicationDetail($payment['application_id']),
            'receivedBy' => (new \App\Models\UserModel())->find($payment['received_by']),
            'companyDetail' => $companyModel->getCompany(),
            'totalPaid' => $this->paymentModel->getTotalPaid($payment['application_id']),
        ];

        return view('payments/receipt', $data);
    }

    // Record a payment
    public function pay($installment_id)
    {
        if (!auth()->user()->can('payments_create')) {
            return view('errors/no_access');
        }

        if ($this->request->getMethod() === 'POST') {
            $amount = $this->request->getPost('amount');
            $method = $this->request->getPost('method');
            $ref    = $this->paymentModel->generateTransactionRef();

            $this->paymentModel->save([
                'installment_id' => $installment_id,
                'payment_date'   => date('Y-m-d'),
                'amount'         => $amount,
                'method'         => $method,
                'reference_no'   => $ref,
                'received_by'    => session()->get('user_id')
            ]);

            $this->installmentModel->update($installment_id, [
                'status' => 'paid',
                'paid_date' => date('Y-m-d')
            ]);

            return redirect()->back()->with('success', 'Payment Recorded');
        }

        $data['installment_id'] = $installment_id;
        return view('payments/pay', $data);
    }

    // Run overdue check
    public function checkOverdue()
    {
        $this->installmentModel->markOverdue();
        return "Overdue check complete.";
    }

    public function store($installment_id)
    {
        if (!auth()->user()->can('payments_create')) {
            return view('errors/no_access');
        }

        if ($this->request->getMethod() === 'POST') {
            $amount = $this->request->getPost('amount');
            $method = $this->request->getPost('method');
            $ref    = $this->paymentModel->generateTransactionRef();

            $this->paymentModel->save([
                'installment_id' => $installment_id,
                'payment_date'   => date('Y-m-d'),
                'amount'         => $amount,
                'method'         => $method,
                'reference_no'   => $ref,
                'received_by'    => session()->get('user_id')
            ]);
            logAudit('CREATE', 'Payments', $this->paymentModel->insertID(), [], $this->request->getPost());

            $this->installmentModel->update($installment_id, [
                'status' => 'paid',
                'paid_date' => date('Y-m-d')
            ]);

            return redirect()->back()->with('success', 'Payment Recorded');
        }

        $data['installment_id'] = $installment_id;
        return view('payments/pay', $data);
    }

    public function update($id)
    {
        if (!auth()->user()->can('payments_update')) {
            return view('errors/no_access');
        }

        if ($this->request->getMethod() === 'POST') {
            $amount = $this->request->getPost('amount');
            $method = $this->request->getPost('method');

            $this->paymentModel->update($id, [
                'amount' => $amount,
                'method' => $method,
                'updated_by' => session()->get('user_id')
            ]);
            logAudit('UPDATE', 'Payments', $id, $this->paymentModel->find($id), $this->request->getPost());

            return redirect()->back()->with('success', 'Payment Updated');
        }

        $data['payment'] = $this->paymentModel->find($id);
        return view('payments/edit', $data);
    }

    public function delete($id)
    {
        if (!auth()->user()->can('payments_delete')) {
            return view('errors/no_access');
        }

        $payment = $this->paymentModel->find($id);
        if (!$payment) {
            return redirect()->back()->with('error', 'Payment not found');
        }
        logAudit('DELETE', 'Payments', $id, $this->paymentModel->find($id), []);
        $this->paymentModel->delete($id);

        return redirect()->back()->with('success', 'Payment Deleted');
    }
}

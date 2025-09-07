<?php

namespace App\Controllers;

use App\Models\ApplicationsModel;
use App\Models\CustomersModel;
use App\Models\PlotsModel;
use App\Models\ProjectsModel;
use App\Models\PaymentModel;
use App\Models\InstallmentModel;
use App\Models\InstallmentPlansModel;
use App\Models\PrintLogModel;
use CodeIgniter\Controller;
use App\Models\LetterPrintHistoryModel;
use App\Models\CompanyModel;
use App\Models\TermsModel;

class Applications extends Controller
{
    protected $applicationModel;
    protected $customerModel;
    protected $plotModel;
    protected $projectModel;
    protected $paymentModel;
    protected $printLogModel;
    protected $installmentPlansModel;
    protected $installmentModel;
    protected $letterModel;
    protected $companyModel;


    public function __construct()
    {
        $this->applicationModel = new ApplicationsModel();
        $this->customerModel = new CustomersModel();
        $this->plotModel = new PlotsModel();
        $this->projectModel = new ProjectsModel();
        $this->paymentModel = new PaymentModel();
        $this->printLogModel = new PrintLogModel();
        $this->installmentModel = new InstallmentModel();
        $this->letterModel = new LetterPrintHistoryModel();
        $this->installmentPlansModel = new InstallmentPlansModel();
        $this->companyModel = new CompanyModel();
        helper(['audit', 'auth']);
    }

    public function index()
    {
        if (!auth()->user()->can('applications_view')) {
            return view('errors/no_access');
        }

        $data['applications'] = $this->applicationModel
            ->select('applications.*, customers.name as customer_name, plots.plot_no, projects.name as project_name')
            ->join('customers', 'customers.id = applications.customer_id')
            ->join('plots', 'plots.id = applications.plot_id')
            ->join('projects', 'projects.id = applications.project_id')
            ->orderBy('applications.id', 'DESC')
            ->findAll();

        return view('applications/index', $data);
    }

    public function create()
    {
        if (!auth()->user()->can('applications_create')) {
            return view('errors/no_access');
        }

        $projectModel = new ProjectsModel();
        $customerModel = new CustomersModel();

        $data['projects'] = $projectModel->findAll();
        $data['plots'] = $this->plotModel->where('status', 'available')->findAll();
        $data['customers'] = $customerModel->where('status', 'active')->findAll();
        $data['app_no'] = $this->applicationModel->generateAppNo();
        $data['installmentPlans'] = $this->installmentPlansModel->findAll();

        return view('applications/create', $data);
    }

    public function store()
    {
        //validations
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'project_id'      => 'required',
            'phase_id'        => 'required',
            'sector_id'       => 'required',
            'street_id'       => 'required',
            'plot_id'         => 'required',
            'customer_id'     => 'required',
            'app_no'          => 'required',
            'app_date'        => 'required',
            'booking_amount'  => 'required',
            'installment_plan_id' => 'required',
            'terms_accepted'  => 'required',

        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Start transaction
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Save application
            $insertResult = $this->applicationModel->save([
                'project_id'      => $this->request->getPost('project_id'),
                'phase_id'        => $this->request->getPost('phase_id'),
                'sector_id'       => $this->request->getPost('sector_id'),
                'street_id'       => $this->request->getPost('street_id'),
                'plot_id'         => $this->request->getPost('plot_id'),
                'customer_id'     => $this->request->getPost('customer_id'),
                'app_no'          => $this->request->getPost('app_no'),
                'app_date'        => $this->request->getPost('app_date'),
                'booking_amount'  => $this->request->getPost('booking_amount'),
                'installment_plan_id' => $this->request->getPost('installment_plan_id'),
                'terms_accepted'  => $this->request->getPost('terms_accepted') ?? 0,
                'status'          => 'Booked',
                'user_id'        => session()->get('user_id')
            ]);

            if ($insertResult === false) {
                $db->transRollback();
                $errors = $this->applicationModel->errors();
                return redirect()->back()->with('error', 'Application insert failed: ' . implode(', ', $errors));
            }

            // Save installment
            $applicationId = $this->applicationModel->insertID();
            $insertResult = $this->installmentModel->insert([
                'application_id' => $applicationId,
                'installment_no' => 1,
                'due_date' => date('Y-m-d'),
                'amount' => $this->request->getPost('booking_amount'),
                'head' => 'DownPayment',
                'status' => 'paid'
            ]);

            if ($insertResult === false) {
                $db->transRollback();
                $errors = $this->installmentModel->errors();
                return redirect()->back()->with('error', 'Installment insert failed: ' . implode(', ', $errors));
            }

            // Save payment
            $installmentId = $this->installmentModel->insertID();
            $insertResult =  $this->paymentModel->insert([
                'installment_id' => $installmentId,
                'application_id' => $applicationId,
                'paid_amount' => $this->request->getPost('booking_amount'),
                'payment_date' => date('Y-m-d'),
                'payment_method' => $this->request->getPost('method') ?? 'cash',
                'transaction_ref' => $this->paymentModel->generateTransactionRef(),
                'received_by' => session()->get('user_id')
            ]);

            if ($insertResult === false) {
                $db->transRollback();
                $errors = $this->paymentModel->errors();
                return redirect()->back()->with('error', 'Payment insert failed: ' . implode(', ', $errors));
            }

            // Update plot status → booked
            $this->plotModel->update($this->request->getPost('plot_id'), ['status' => 'booked']);

            logAudit('CREATE', 'Applications', $applicationId, [], $this->request->getPost());

            $db->transComplete();

            return redirect()->to('/applications')->with('success', 'Application/Booking created successfully.');
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Failed to create booking: ' . $e->getMessage());
        }
    }

    // Booking Detail Page
    public function view($id)
    {
        $application = $this->applicationModel->find($id);
        if (!$application) {
            return redirect()->to('/applications')->with('error', 'Application not found');
        }

        $customer = $this->customerModel->find($application['customer_id']);
        $plot = $this->plotModel->find($application['plot_id']);
        $project = $this->projectModel->find($application['project_id']);
        $payments = $this->paymentModel->where('installment_id', $id)->findAll();
        $printLogs = $this->printLogModel->where('application_id', $id)->findAll();

        return view('applications/view', [
            'application' => $application,
            'customer' => $customer,
            'plot' => $plot,
            'project' => $project,
            'payments' => $payments,
            'printLogs' => $printLogs
        ]);
    }

    public function detail($appId)
    {
        $appModel = new ApplicationsModel();
        $customerModel = new CustomersModel();
        $plotModel = new PlotsModel();
        $installmentModel = new installmentModel();
        $letterModel = new LetterPrintHistoryModel();

        $totalDue = $this->installmentModel->getTotalDue($appId);

        $application = $appModel->find($appId);
        $customer = $customerModel->find($application['customer_id']);
        $plot = $plotModel->find($application['plot_id']);
        $installments = $installmentModel->where('application_id', $appId)->findAll();
        $letterHistory = $letterModel->where('application_id', $appId)->findAll();
        $payments = $this->paymentModel->where('application_id', $appId)->findAll();

        return view('applications/detail', [
            'application' => $application,
            'customer' => $customer,
            'plot' => $plot,
            'installments' => $installments,
            'payments' => $payments,
            'letterHistory' => $letterHistory,
            'totalDue' => $totalDue
        ]);
    }
    public function issueFinalAllotment($appId)
    {
        // Fetch total due
        $totalDue = $this->installmentModel->getTotalDue($appId);

        // Fetch total paid
        $totalPaid = $this->paymentModel
            ->selectSum('paid_amount')
            ->where('application_id', $appId)
            ->get()->getRow()->amount ?? 0;

        // Check dues
        if ($totalPaid < $totalDue) {
            return redirect()->back()->with('error', 'Cannot issue final allotment. Pending dues exist.');
        }

        // Update status to Completed
        $this->applicationModel->update($appId, [
            'status'     => 'Completed',
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        // Check if already printed
        // Check duplicate
        $type = 'allotment';
        $isDuplicate = $this->letterModel->where('application_id', $appId)
            ->where('letter_type', $type)
            ->countAllResults() > 0;

        // Log the print
        $this->letterModel->insert([
            'application_id' => $appId,
            'letter_type'    => $type,
            'printed_by'     => session()->get('user_id'),
            'is_duplicate'   => $isDuplicate ? 1 : 0
        ]);


        return redirect()->to("/applications/view/$appId")
            ->with('success', 'Final Allotment issued successfully. Ready for printing.');
    }

    // Print Provisional or Allotment Letter
    public function printLetter($appId, $type = 'provisional')
    {


        $letterModel = new LetterPrintHistoryModel();
        $appModel = new ApplicationsModel();
        $installmentPlansModel = new InstallmentPlansModel();
        $application = $appModel->getApplicationDetail($appId);
        $installmentPlan = null;
        $companyDetail = $this->companyModel->getCompany();
        $plotDetail = $this->plotModel->getPlotDetails($application['plot_id']);

        if ($application && !empty($application['installment_plan_id'])) {
            $installmentPlan = $installmentPlansModel->find($application['installment_plan_id']);
        }

        // Check duplicate
        $isDuplicate = $letterModel->where('application_id', $appId)
            ->where('letter_type', $type)
            ->countAllResults() > 0;

        if ($isDuplicate > 0 && !auth()->user()->can('applications_print')) {
            return view('errors/no_access');
        }

        $letterModel->insert([
            'application_id' => $appId,
            'letter_type'    => $type,
            'printed_by'     => session()->get('user_id'),
            'is_duplicate'   => $isDuplicate ? 1 : 0
        ]);

        // Application status to provisional
        $this->applicationModel->update($appId, [
            'status'     => $type === 'provisional' ? 'Provisional' : 'Completed',
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        //log
        logAudit('PRINT', 'Applications', $appId, $application, ['letter_type' => $type]);


        // Load print view
        return view("applications/letters/{$type}", [
            'application' => $application,
            'installmentPlan' => $installmentPlan,
            'isDuplicate' => $isDuplicate,
            'companyDetail' => $companyDetail,
            'plotDetail' => $plotDetail
        ]);
    }

    public function edit($id)
    {
        if (!auth()->user()->can('applications_edit')) {
            return view('errors/no_access');
        }

        $data['application'] = $this->applications->find($id);
        $data['customers'] = $this->customers->findAll();
        $data['plots'] = $this->plots->findAll();
        $data['installmentPlans'] = $this->installmentPlans->findAll();
        return view('applications/edit', $data);
    }

    public function update($id)
    {
        $this->applications->update($id, [
            'customer_id'     => $this->request->getPost('customer_id'),
            'plot_id'         => $this->request->getPost('plot_id'),
            'application_date' => $this->request->getPost('application_date'),
            'total_price'     => $this->request->getPost('total_price'),
            'down_payment'    => $this->request->getPost('down_payment'),
            'installment_plan_id' => $this->request->getPost('installment_plan_id'),
            'status'          => $this->request->getPost('status'),
        ]);

        return redirect()->to('/applications');
    }
    // Add to your application controller
    public function printApplication($applicationId)
    {
        $application = $this->applicationModel->getApplicationForPrint($applicationId);
        $termsModel = new TermsModel();
        $terms = $termsModel->first();

        if (!$application) {
            return redirect()->to('/applications')->with('error', 'Application not found');
        }

        $data = [
            'application' => $application,
            'signature' => [], //$this->applicationModel->getSignature($applicationId)
            'companyDetail' => $this->companyModel->getCompany(),
            'terms' => $terms,
        ];

        // return view('applications/print_application', $data);
        return view('applications/print', $data);
    }
    public function printApplication_1($applicationId)
    {
        $application = $this->applicationModel->getApplicationForPrint($applicationId);

        if (!$application) {
            return redirect()->to('/applications')->with('error', 'Application not found');
        }

        $data = [
            'application' => $application,
            'signature' => [], //$this->applicationModel->getSignature($applicationId)
            'companyDetail' => $this->companyModel->getCompany(),

        ];

        return view('applications/print_application', $data);
    }


    public function downloadApplication($applicationId)
    {
        $application = $this->applicationModel->getApplicationForPrint($applicationId);

        if (!$application) {
            return redirect()->to('/applications')->with('error', 'Application not found');
        }

        $data = [
            'application' => $application,
            'signature' => [], // $this->applicationModel->getSignature($applicationId)
            'companyDetail' => $this->companyModel->getCompany(),
        ];

        $html = view('applications/print', $data);

        // Generate PDF using dompdf
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'booking_application_' . $application['app_no'] . '.pdf';

        return $dompdf->stream($filename);
    }

    public function delete($id)
    {
        if (!auth()->user()->can('applications_delete')) {
            return view('errors/no_access');
        }

        $application = $this->applicationModel->find($id);
        if ($application['status'] !== 'Completed') {
            // Start transaction
            $db = \Config\Database::connect();
            $db->transStart();
            try {
                $this->plotModel->update($application['plot_id'], ['status' => 'Available']);
                $this->installmentModel->where('application_id', $id)->delete();
                $this->letterModel->where('application_id', $id)->delete();
                $this->paymentModel->where('application_id', $id)->delete();
                $this->applicationModel->delete($id);
                // Log the audit
                logAudit('DELETE', 'Applications', $id, $application, ['App No:' => $application['app_no'], 'Plot Id:' => $application['plot_id']]);
                $db->transComplete();
            } catch (\Exception $e) {
                $db->transRollback();
                return redirect()->to('/applications')->with('error', 'Failed to delete application.');
            }
            // Free up the plot again

        } else {
            return redirect()->to('/applications')->with('error', 'Completed applications cannot be deleted.');
        }
        return redirect()->to('/applications')->with('success', 'Application deleted successfully.');
    }
}

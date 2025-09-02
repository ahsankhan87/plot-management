<?php

namespace App\Controllers;

use App\Models\TransferModel;
use App\Models\ApplicationsModel;
use App\Models\CustomersModel;
use App\Models\PaymentModel;
use App\Models\PlotsModel;

class Transfers extends BaseController
{
    protected $transferModel;
    protected $applicationsModel;
    protected $customersModel;
    protected $paymentModel;
    protected $plotModel;

    public function __construct()
    {
        $this->transferModel = new TransferModel();
        $this->applicationsModel = new ApplicationsModel();
        $this->customersModel = new CustomersModel();
        $this->paymentModel = new PaymentModel();
        $this->plotModel = new PlotsModel();

        helper(['form', 'filesystem', 'audit', 'auth']);
    }

    public function index()
    {
        if (!auth()->user()->can('transfer_view')) {
            return view('errors/no_access');
        }
        $status = $this->request->getGet('status');
        $filters = [];

        if ($status) {
            $filters['status'] = $status;
        }

        $data = [
            'transfers' => $this->transferModel->getAllTransfers($filters),
            'statuses' => ['pending', 'approved', 'rejected'],
            'currentStatus' => $status
        ];

        return view('transfers/index', $data);
    }

    public function create($applicationId = null)
    {
        if (!auth()->user()->can('transfer_create')) {
            return view('errors/no_access');
        }
        $data = [
            'application' => null,
            'currentCustomer' => null,
            'validation' => \Config\Services::validation()
        ];

        if ($applicationId) {
            $application = $this->applicationsModel->getApplicationDetails($applicationId);
            if ($application) {
                $data['application'] = $application;
                $data['currentCustomer'] = $this->customersModel->find($application['customer_id']);

                // Check if transfer is allowed
                if (!$this->transferModel->isApplicationTransferable($applicationId)) {
                    return redirect()->back()->with('error', 'This application is not eligible for transfer. Minimum 25% payment required.');
                }
            }
        }

        $data['customers'] = $this->customersModel->findAll();
        $data['transferFee'] = $this->transferModel->calculateTransferFee();

        return view('transfers/create', $data);
    }

    public function store()
    {
        $rules = [
            'application_id' => 'required|numeric',
            'new_customer_id' => 'required|numeric',
            'transfer_date' => 'required|valid_date',
            'transfer_amount' => 'permit_empty|numeric',
            'reason' => 'required|min_length[10]',
            'terms_accepted' => 'required',

        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $postData = $this->request->getPost();

        $applicationId = $postData['application_id'];

        // Validate transfer eligibility
        if (!$this->transferModel->isApplicationTransferable($applicationId)) {
            return redirect()->back()->withInput()->with('error', 'This application is not eligible for transfer. Minimum 25% payment required.');
        }

        $application = $this->applicationsModel->find($applicationId);

        // Handle document uploads
        $documentFile = $this->request->getFile('documents');
        $documentName = null;
        if ($documentFile && $documentFile->isValid() && !$documentFile->hasMoved()) {
            $documentName = $documentFile->getRandomName();
            $documentFile->move(ROOTPATH . 'public/uploads/transfers', $documentName);
        }

        // Prepare transfer data
        $transferData = [
            'application_id' => $applicationId,
            'current_customer_id' => $application['customer_id'],
            'new_customer_id' => $postData['new_customer_id'],
            'transfer_date' => $postData['transfer_date'],
            'transfer_amount' => $postData['transfer_amount'] ?? null,
            'transfer_fee' => $this->transferModel->calculateTransferFee($postData['transfer_amount'] ?? null),
            'reason' => $postData['reason'],
            'terms_accepted' => true,
            'created_by' => session()->get('user_id'),
            'transfer_documents' => $documentName
        ];

        // Handle document uploads
        // $documents = $this->handleDocumentUploads();
        // if ($documents) {
        //     $transferData['transfer_documents'] = json_encode($documents);
        // }


        if ($this->transferModel->save($transferData)) {
            logAudit('CREATE', 'Transfer', $this->transferModel->getInsertID(), null, $transferData);
            return redirect()->to('/transfers')->with('success', 'Transfer request submitted successfully. Waiting for approval.');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to create transfer request');
    }

    public function view($id)
    {
        if (!auth()->user()->can('transfer_view')) {
            return view('errors/no_access');
        }
        $transfer = $this->transferModel->getTransferWithDetails($id);
        if (!$transfer) {
            return redirect()->to('/transfers')->with('error', 'Transfer not found');
        }

        // Get booking details
        $booking = $this->applicationsModel->getApplicationDetail($transfer['application_id']);

        // Get new customer details
        $newCustomer = $this->customersModel->find($transfer['new_customer_id']);

        // Get created by user details
        $userModel = new \App\Models\UserModel();
        $createdBy = $userModel->find($transfer['created_by']);

        // Get payment summary
        $paymentSummary = $this->getPaymentSummary($transfer['application_id']);

        $data = [
            'transfer' => $transfer,
            'booking' => $booking,
            'newCustomer' => $newCustomer,
            'createdBy' => $createdBy,
            'paymentSummary' => $paymentSummary
        ];

        return view('transfers/view', $data);
    }

    public function approve($id)
    {
        if (!auth()->user()->can('transfer_create')) {
            return view('errors/no_access');
        }
        $transfer = $this->transferModel->find($id);
        $application = $this->applicationsModel->find($transfer['application_id']);

        if (!$transfer) {
            return redirect()->back()->with('error', 'Transfer not found');
        }

        if ($transfer['approval_status'] !== 'pending') {
            return redirect()->back()->with('error', 'Transfer is already processed');
        }

        if ($this->transferModel->approveTransfer($id, session()->get('user_id'))) {

            // Update plot status →  transferred
            $this->plotModel->update($application['plot_id'], ['status' => 'transferred']);

            logAudit('APPROVE', 'Transfer', $id, $transfer, ['approved_by' => session()->get('user_id')]);
            return redirect()->to('/transfers/view/' . $id)->with('success', 'Transfer approved successfully');
        }

        return redirect()->back()->with('error', 'Failed to approve transfer');
    }

    public function reject($id)
    {
        if (!auth()->user()->can('transfer_create')) {
            return view('errors/no_access');
        }
        $reason = $this->request->getPost('rejection_reason');

        if ($this->transferModel->rejectTransfer($id, session()->get('user_id'), $reason)) {
            logAudit('REJECT', 'Transfer', $id, null, ['rejected_by' => session()->get('user_id'), 'reason' => $reason]);
            return redirect()->to('/transfers/view/' . $id)->with('success', 'Transfer rejected successfully');
        }

        return redirect()->back()->with('error', 'Failed to reject transfer');
    }

    public function generateAgreement($id)
    {
        if (!auth()->user()->can('transfer_view')) {
            return view('errors/no_access');
        }
        $transfer = $this->transferModel->getTransferWithDetails($id);
        if (!$transfer) {
            return redirect()->back()->with('error', 'Transfer not found');
        }

        $data = [
            'transfer' => $transfer,
            'application' => $this->applicationsModel->getApplicationDetail($transfer['application_id']),
            'paymentSummary' => $this->getPaymentSummary($transfer['application_id'])
        ];

        return view('transfers/agreement_template', $data);
    }

    private function handleDocumentUploads()
    {
        $uploadedDocs = [];
        $files = $this->request->getFiles();

        if ($files) {
            foreach ($files as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move(WRITEPATH . 'uploads/transfers', $newName);

                    $uploadedDocs[] = [
                        'name' => $file->getName(),
                        'path' => 'transfers/' . $newName,
                        'uploaded_at' => date('Y-m-d H:i:s')
                    ];
                }
            }
        }

        return $uploadedDocs;
    }

    private function getPaymentSummary($applicationId)
    {
        $totalPaid = $this->paymentModel->getTotalPaid($applicationId);
        $application = $this->applicationsModel->find($applicationId);
        $plot = $this->plotModel->find($application['plot_id']);
        $balance = $plot['base_price'] - $totalPaid;

        return [
            'total_price' => $plot['base_price'],
            'total_paid' => $totalPaid,
            'balance' => $balance,
            'completion_percentage' => ($totalPaid / $plot['base_price']) * 100
        ];
    }

    // AJAX endpoint to check transfer eligibility
    public function checkEligibility($applicationId)
    {
        $isEligible = $this->transferModel->isApplicationTransferable($applicationId);
        $application = $this->applicationsModel->getApplicationDetail($applicationId);
        $paymentSummary = $this->getPaymentSummary($applicationId);

        return $this->response->setJSON([
            'eligible' => $isEligible,
            'application' => $application,
            'payment_summary' => $paymentSummary,
            'min_required' => $application['total_price'] * 0.25,
            'transfer_fee' => $this->transferModel->calculateTransferFee()
        ]);
    }

    // AJAX endpoint to get customer details
    public function getCustomerDetails($customerId)
    {
        $customer = $this->customerModel->find($customerId);
        return $this->response->setJSON($customer ?: []);
    }
}

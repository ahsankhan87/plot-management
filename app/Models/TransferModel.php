<?php

namespace App\Models;

use CodeIgniter\Model;

class TransferModel extends Model
{
    protected $table = 'plot_transfers';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'application_id',
        'current_customer_id',
        'new_customer_id',
        'transfer_date',
        'transfer_amount',
        'transfer_fee',
        'approval_status',
        'approved_by',
        'approval_date',
        'reason',
        'terms_accepted',
        'transfer_documents',
        'created_by'
    ];

    protected $validationRules = [
        'application_id' => 'required|numeric',
        'current_customer_id' => 'required|numeric',
        'new_customer_id' => 'required|numeric',
        'transfer_date' => 'required|valid_date',
        'transfer_amount' => 'permit_empty|numeric',
        'reason' => 'required|min_length[10]',
        'terms_accepted' => 'required'
    ];

    protected $validationMessages = [
        'terms_accepted' => [
            'required' => 'You must accept the transfer terms and conditions'
        ]
    ];

    // Check if application is eligible for transfer
    public function isApplicationTransferable($applicationId)
    {
        $applicationModel = new \App\Models\ApplicationsModel();
        $paymentModel = new \App\Models\PaymentModel();
        $plotModel = new \App\Models\PlotsModel();

        $application = $applicationModel->find($applicationId);
        if (!$application) {
            return false;
        }

        $plot = $plotModel->find($application['plot_id']);
        if (!$plot) {
            return false;
        }
        // Check if at least 25% of total amount is paid
        $totalPaid = $paymentModel->getTotalPaid($applicationId);
        $minRequired = $plot['base_price'] * 0.25;

        return $totalPaid >= $minRequired;
    }


    // Get transfer with details
    public function getTransferWithDetails($transferId)
    {
        $builder = $this->db->table('plot_transfers pt');
        $builder->select('pt.*, 
        b.app_no,
        uc.name as current_customer_name, uc.cnic as current_customer_cnic,
        uc.father_husband as current_customer_father_husband,
        un.name as new_customer_name, un.cnic as new_customer_cnic,
        un.father_husband as new_customer_father_husband,
        u.plot_no, bl.name as project_name,
        approver.name as approved_by_name,
        creator.name as created_by_name');
        $builder->join('applications b', 'b.id = pt.application_id');
        $builder->join('customers uc', 'uc.id = pt.current_customer_id');
        $builder->join('customers un', 'un.id = pt.new_customer_id');
        $builder->join('plots u', 'u.id = b.plot_id');
        $builder->join('projects bl', 'bl.id = b.project_id');
        $builder->join('users approver', 'approver.id = pt.approved_by', 'left');
        $builder->join('users creator', 'creator.id = pt.created_by', 'left');
        $builder->where('pt.id', $transferId);

        return $builder->get()->getRowArray();
    }

    // Calculate transfer fee
    public function calculateTransferFee($transferAmount = null)
    {
        $settingsModel = null; // new \App\Models\SettingsModel();
        // $settings = $settingsModel->first();

        $feePercentage =  2.5; //$settings['transfer_fee_percentage'] ??
        $minFee = 5000; //$settings['min_transfer_fee'] ?? 5000;

        if ($transferAmount) {
            $calculatedFee = ($transferAmount * $feePercentage) / 100;
            return max($calculatedFee, $minFee);
        }

        return $minFee;
    }

    // Get all transfers with filters
    public function getAllTransfers($filters = [])
    {
        $builder = $this->db->table('plot_transfers pt');
        $builder->select('pt.*, 
            b.app_no,
            uc.name as current_customer_name,
            uc.cnic as current_customer_cnic,
            un.name as new_customer_name,
            un.cnic as new_customer_cnic,
            u.plot_no, bl.name as project_name');
        $builder->join('applications b', 'b.id = pt.application_id');
        $builder->join('customers uc', 'uc.id = pt.current_customer_id');
        $builder->join('customers un', 'un.id = pt.new_customer_id');
        $builder->join('plots u', 'u.id = b.plot_id');
        $builder->join('projects bl', 'bl.id = b.project_id');

        if (!empty($filters['status'])) {
            $builder->where('pt.approval_status', $filters['status']);
        }

        if (!empty($filters['application_id'])) {
            $builder->where('pt.application_id', $filters['application_id']);
        }

        if (!empty($filters['customer_id'])) {
            $builder->where('pt.current_customer_id', $filters['customer_id'])
                ->orWhere('pt.new_customer_id', $filters['customer_id']);
        }

        $builder->orderBy('pt.created_at', 'DESC');

        return $builder->get()->getResultArray();
    }

    // Approve transfer
    public function approveTransfer($transferId, $approvedBy)
    {
        $transfer = $this->find($transferId);
        if (!$transfer) {
            return false;
        }

        $this->db->transStart();

        try {
            // Update transfer status
            $this->update($transferId, [
                'approval_status' => 'approved',
                'approved_by' => $approvedBy,
                'approval_date' => date('Y-m-d')
            ]);

            // Update application with new customer
            $applicationModel = new \App\Models\ApplicationsModel();
            $applicationModel->update($transfer['application_id'], [
                'customer_id' => $transfer['new_customer_id']
            ]);

            // Create audit log
            // $auditLog = new \App\Models\AuditLogModel();
            // $auditLog->logTransferApproval($transferId, $approvedBy);

            $this->db->transComplete();

            return $this->db->transStatus();
        } catch (\Exception $e) {
            $this->db->transRollback();
            throw $e;
        }
    }

    // Reject transfer
    public function rejectTransfer($transferId, $approvedBy, $reason = null)
    {
        return $this->update($transferId, [
            'approval_status' => 'rejected',
            'approved_by' => $approvedBy,
            'approval_date' => date('Y-m-d'),
            'reason' => $reason ?: $this->find($transferId)['reason']
        ]);
    }
}

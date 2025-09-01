<?php

namespace App\Models;

use CodeIgniter\Model;

class InstallmentModel extends Model
{
    protected $table = 'installments';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'application_id',
        'installment_no',
        'due_date',
        'amount',
        'status',
        'head'
    ];

    public function getByApplication($application_id)
    {
        return $this->where('application_id', $application_id)->findAll();
    }

    public function getUnpaidInstallments($application_id)
    {
        // Fetch unpaid installments sorted by due date
        return $this->select('*')
            ->where('application_id', $application_id)
            ->groupStart()
            ->where('status', 'pending')
            ->orWhere('status', 'overdue')
            ->groupEnd()
            ->orderBy('due_date', 'ASC')
            ->findAll();
    }

    public function getTotalDue($application_id)
    {
        return $this->selectSum('amount')
            ->where('application_id', $application_id)
            ->groupStart()
            ->where('status', 'pending')
            ->orWhere('status', 'overdue')
            ->groupEnd()
            ->get()->getRow()->amount ?? 0;
    }

    public function markOverdue()
    {
        return $this->where('status', 'pending')
            ->where('due_date <', date('Y-m-d', strtotime('-3 months')))
            ->set(['status' => 'cancelled'])
            ->update();
    }
}

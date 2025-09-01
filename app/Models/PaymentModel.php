<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'installment_id',
        'payment_date',
        'paid_amount',
        'payment_method',
        'transaction_ref',
        'received_by',
        'application_id',
        'remarks'
    ];

    public function getByInstallment($installment_id)
    {
        return $this->where('installment_id', $installment_id)->findAll();
    }

    public function generateTransactionRef()
    {
        // Generate a unique transaction reference
        $prefix = "INV-" . date("Ym") . "-";
        $last = $this->orderBy('id', 'DESC')->first();
        $next = ($last) ? $last['id'] + 1 : 1;
        return $prefix . str_pad($next, 4, "0", STR_PAD_LEFT);
    }

    protected $validationRules = [
        'application_id' => 'required|numeric',
        'paid_amount' => 'required|numeric',
        'payment_date' => 'required|valid_date',
        'payment_method' => 'required|in_list[cash,bank,cheque,pay_order,online]'
    ];

    // Get payments by application ID
    public function getPaymentsByApplication($applicationId)
    {
        return $this->where('application_id', $applicationId)
            ->orderBy('payment_date', 'ASC')
            ->findAll();
    }

    // Get last payment for a application
    public function getLastPayment($applicationId)
    {
        return $this->where('application_id', $applicationId)
            ->orderBy('payment_date', 'DESC')
            ->first();
    }

    // Get total paid amount for application
    public function getTotalPaid($applicationId)
    {
        $result = $this->selectSum('paid_amount')
            ->where('application_id', $applicationId)
            ->first();

        return $result['paid_amount'] ?? 0;
    }

    // Check if payment is overdue
    public function isPaymentOverdue($bookingId)
    {
        $planModel = new \App\Models\InstallmentPlansModel();
        $plan = $planModel->getPlanByBooking($bookingId);

        if (!$plan) return false;

        $lastPayment = $this->getLastPayment($bookingId);
        $lastDate = $lastPayment ? $lastPayment['payment_date'] : $plan['start_date'];

        $nextDue = date('Y-m-d', strtotime($lastDate . ' +1 month'));
        return strtotime(date('Y-m-d')) > strtotime($nextDue);
    }

    public function getOverduePayments()
    {
        $installmentModel = new \App\Models\InstallmentModel();
        return $installmentModel->select('installments.*, customers.name as customer_name')
            ->join('applications', 'applications.id = installments.application_id')
            ->join('customers', 'customers.id = applications.customer_id')
            ->where('installments.status', 'pending')
            ->where('installments.due_date <', date('Y-m-d', strtotime('-1 months')))
            ->orderBy('due_date', 'ASC')->find();
    }
}

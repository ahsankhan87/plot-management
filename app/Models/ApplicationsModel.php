<?php

namespace App\Models;

use CodeIgniter\Model;

/* ===============================
   APPLICATIONS
   =============================== */

class ApplicationsModel extends Model
{
    protected $table      = 'applications';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'customer_id',
        'project_id',
        'phase_id',
        'sector_id',
        'street_id',
        'plot_id',
        'app_no',
        'app_date',
        'status',
        'created_at',
        'booking_amount',
        'installment_plan_id',
        'terms_accepted',
        'user_id'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';

    public function getApplicationDetail($id)
    {
        return $this->select('applications.*, customers.name as customer_name,customers.email,
        customers.phone,customers.residential_address, plots.plot_no,plots.base_price, projects.name as project_name')
            ->join('customers', 'customers.id = applications.customer_id')
            ->join('plots', 'plots.id = applications.plot_id')
            ->join('projects', 'projects.id = applications.project_id')
            ->where('applications.id', $id)
            ->first();
    }
    // Auto-generate application number (APP-YYYYMM-XXXX)
    public function generateAppNo()
    {
        $prefix = "APP-" . date("Ym") . "-";
        $last = $this->orderBy('id', 'DESC')->first();
        $next = ($last) ? $last['id'] + 1 : 1;
        return $prefix . str_pad($next, 4, "0", STR_PAD_LEFT);
    }
    // Generate unique registration numbers
    public function generateRegistrationNo()
    {
        $prefix = 'REG-' . date('Y') . '-';
        $last = $this->like('registration_no', $prefix, 'after')
            ->orderBy('id', 'DESC')
            ->first();

        $nextNum = $last ? ((int)str_replace($prefix, '', $last['registration_no'])) + 1 : 1;
        return $prefix . str_pad($nextNum, 5, '0', STR_PAD_LEFT);
    }
}

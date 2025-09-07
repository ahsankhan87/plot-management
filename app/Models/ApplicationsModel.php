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
    // Add to your BookingModel class
    public function getApplicationForPrint($applicationId)
    {
        $builder = $this->db->table('applications a');
        $builder->select('a.*, c.name as customer_name, c.father_husband, c.cnic, c.postal_address, c.photo_path as photo,
                     c.residential_address, c.phone, c.mobile, c.email, c.nationality,c.nominee_phone,c.occupation,
                     c.dob,c.nominee_photo, c.nominee_name, c.nominee_relation, c.nominee_address, 
                     c.nominee_cnic, p.base_price as total_price, p.plot_no, p.size as plot_size,p.area_sqft,
                     s.name as sector_name, s.phase_id,ip.name as installment_plan_name, 
                     ip.tenure_months, ph.name as phase_name, pr.name as project_name,
                     st.street_no, py.paid_amount as payment_amount, py.payment_date, py.payment_method,
                     py.id as transaction_id, py.remarks,py.transaction_ref as payment_ref,
                     i.due_date as installment_due_date, i.amount as installment_amount, i.status as installment_status');
        $builder->join('customers c', 'c.id = a.customer_id', 'left');
        $builder->join('plots p', 'p.id = a.plot_id', 'left');
        $builder->join('projects pr', 'pr.id = p.project_id', 'left');
        $builder->join('sectors s', 's.id = p.sector_id', 'left');
        $builder->join('phases ph', 'ph.id = p.phase_id', 'left');
        $builder->join('streets st', 'st.id = p.street_id', 'left');
        $builder->join('installment_plans ip', 'ip.id = a.installment_plan_id', 'left');
        $builder->join('installments i', 'i.application_id = a.id', 'left');
        $builder->join('payments py', 'py.installment_id = i.id', 'left');
        $builder->where('a.id', $applicationId);
        $builder->where('i.head', 'DownPayment'); // Only include paid installments

        return $builder->get()->getRowArray();
    }

    public function saveSignature($applicationId, $signatureData)
    {
        $data = [
            'signature_data' => $signatureData,
            'signed_at' => date('Y-m-d H:i:s'),
            'signed_by' => session()->get('user_id')
        ];

        return $this->update($applicationId, $data);
    }

    public function getSignature($applicationId)
    {
        $application = $this->select('signature_data, signed_at')->find($applicationId);
        return $application ? $application['signature_data'] : null;
    }
}

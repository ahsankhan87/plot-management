<?php

namespace App\Models;

use CodeIgniter\Model;

class CompanyModel extends Model
{
    protected $table = 'company';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name',
        'address',
        'contact_number',
        'email',
        'logo',
        'website',
        'registration_number',
        'ntn',
        'tagline',
        'bank_account_details',
        'is_setup_complete',
        'setup_date'
    ];

    protected $validationRules = [
        'name' => 'required|max_length[255]',
        'address' => 'required',
        'contact_number' => 'required|max_length[20]',
        'email' => 'required|valid_email|max_length[100]'
    ];

    public function getCompany()
    {
        return $this->first();
    }

    public function isSetupComplete()
    {
        $company = $this->first();
        return $company && $company['is_setup_complete'] == 1;
    }

    public function completeSetup()
    {
        return $this->update(1, [
            'is_setup_complete' => 1,
            'setup_date' => date('Y-m-d H:i:s')
        ]);
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

/* ===============================
   CUSTOMERS
   =============================== */

class CustomersModel extends Model
{
    protected $table      = 'customers';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name',
        'father_husband',
        'cnic',
        'phone',
        'email',
        'address',
        'status',
        'created_at',
        'updated_at',
        'postal_address',
        'residential_address',
        'nominee_name',
        'nominee_relation',
        'nominee_cnic',
        'nominee_address',
        'photo_path'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}

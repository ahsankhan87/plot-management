<?php

namespace App\Models;

use CodeIgniter\Model;

class InstallmentPlansModel extends Model
{
    protected $table = 'installment_plans';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'project_id',
        'name',
        'tenure_months',
        'down_payment_pct',
        'markup_pct',
        'schedule_rule_json'
    ];
}

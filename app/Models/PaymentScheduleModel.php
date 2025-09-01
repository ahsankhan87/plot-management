<?php

namespace App\Models;

use CodeIgniter\Model;

/* ===============================
   PAYMENT SCHEDULE
   =============================== */

class PaymentScheduleModel extends Model
{
    protected $table      = 'payment_schedules';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'application_id',
        'due_date',
        'amount',
        'status',
        'created_at'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
}

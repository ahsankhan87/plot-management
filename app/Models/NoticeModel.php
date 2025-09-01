<?php

namespace App\Models;

use CodeIgniter\Model;

/* ===============================
   NOTICES
   =============================== */

class NoticeModel extends Model
{
    protected $table      = 'notices';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'application_id',
        'notice_type',
        'notice_date',
        'due_date',
        'amount',
        'status',
        'created_at'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
}

<?php

namespace App\Models;

use CodeIgniter\Model;

/* ===============================
   PRINT LOGS
   =============================== */

class PrintLogModel extends Model
{
    protected $table      = 'print_logs';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'application_id',
        'document_type',
        'print_date',
        'printed_by',
        'remarks'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'print_date';
}

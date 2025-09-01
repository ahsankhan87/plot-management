<?php

namespace App\Models;

use CodeIgniter\Model;

/* ===============================
   CUSTOMER LEDGER
   =============================== */

class CustomerLedgerModel extends Model
{
    protected $table = 'customer_ledger';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'customer_id',
        'application_id',
        'transaction_id',
        'transaction_type',
        'reference_no',
        'narration',
        'debit',
        'credit',
        'transaction_date',
        'posted_by'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'posted_at';
}

<?php

namespace App\Models;

use CodeIgniter\Model;

/* ===============================
   ALLOTMENT LETTERS
   =============================== */

class AllotmentLetterModel extends Model
{
    protected $table      = 'allotment_letters';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'application_id',
        'letter_type',
        'issue_date',
        'letter_no',
        'is_duplicate',
        'hash',
        'qr_code',
        'printed_by',
        'printed_at'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'issue_date';
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class LetterPrintHistoryModel extends Model
{
    protected $table = 'letter_print_history';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'application_id',
        'letter_type',
        'printed_by',
        'is_duplicate',
        'created_at'
    ];
    protected $useTimestamps = true;
}

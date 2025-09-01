<?php

namespace App\Models;

use CodeIgniter\Model;

/* ===============================
   BLOCKS
   =============================== */

class BlocksModel extends Model
{
    protected $table      = 'blocks';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'project_id',
        'code',
        'name',
        'created_at'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
}

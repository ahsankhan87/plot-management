<?php

namespace App\Models;

use CodeIgniter\Model;

/* ===============================
   PLOTS
   =============================== */

class PlotsModel extends Model
{
    protected $table      = 'plots';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'plot_no',
        'block_id',
        'size',
        'area_sqft',
        'category',
        'facing',
        'base_price',
        'status',
        'type',
        'created_at'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
}

<?php

namespace App\Models;

use CodeIgniter\Model;

/* ===============================
   Projects     
   =============================== */

class ProjectsModel extends Model
{
    protected $table      = 'projects';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'project_id',
        'code',
        'name',
        'location',
        'created_at'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
}

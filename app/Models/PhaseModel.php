<?php

namespace App\Models;

use CodeIgniter\Model;

class PhaseModel extends Model
{
    protected $table = 'phases';
    protected $primaryKey = 'id';
    protected $allowedFields = ['project_id', 'name', 'description', 'created_at'];
    protected $useTimestamps = true;

    public function getWithProject()
    {
        return $this->select('phases.*, projects.id as project_id, projects.name as project_name')
            ->join('projects', 'projects.id = phases.project_id')
            ->findAll();
    }
}

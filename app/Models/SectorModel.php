<?php

namespace App\Models;

use CodeIgniter\Model;

class SectorModel extends Model
{
    protected $table = 'sectors';
    protected $primaryKey = 'id';
    protected $allowedFields = ['phase_id', 'name', 'description', 'created_at'];

    public function getWithPhase()
    {
        return $this->select('sectors.*, phases.name as phase_name,phases.id as phase_id, projects.name as project_name')
            ->join('phases', 'phases.id = sectors.phase_id')
            ->join('projects', 'projects.id = phases.project_id')
            ->findAll();
    }
}

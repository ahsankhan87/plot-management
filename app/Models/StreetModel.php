<?php

namespace App\Models;

use CodeIgniter\Model;

class StreetModel extends Model
{
    protected $table = 'streets';
    protected $primaryKey = 'id';
    protected $allowedFields = ['sector_id', 'street_no', 'description', 'created_at'];

    public function getWithSector()
    {
        return $this->select('streets.*, sectors.name as sector_name,sectors.id as sector_id, phases.name as phase_name, projects.name as project_name')
            ->join('sectors', 'sectors.id = streets.sector_id')
            ->join('phases', 'phases.id = sectors.phase_id')
            ->join('projects', 'projects.id = phases.project_id')
            ->findAll();
    }
}

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
        'street_id',
        'phase_id',
        'sector_id',
        'project_id',
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

    public function getPlotDetails($id)
    {
        $builder = $this->db->table($this->table);
        $builder->select('plots.*, projects.name as project_name, phases.name as phase_name, sectors.name as sector_name, streets.street_no as street_no');
        $builder->join('projects', 'projects.id = plots.project_id', 'left');
        $builder->join('phases', 'phases.id = plots.phase_id', 'left');
        $builder->join('sectors', 'sectors.id = plots.sector_id', 'left');
        $builder->join('streets', 'streets.id = plots.street_id', 'left');
        $builder->where('plots.id', $id);
        $query = $builder->get();
        return $query->getRowArray();
    }
    public function getAllPlots()
    {
        $builder = $this->db->table($this->table);
        $builder->select('plots.*, projects.name as project_name, phases.name as phase_name, sectors.name as sector_name, streets.street_no as street_no');
        $builder->join('projects', 'projects.id = plots.project_id', 'left');
        $builder->join('phases', 'phases.id = plots.phase_id', 'left');
        $builder->join('sectors', 'sectors.id = plots.sector_id', 'left');
        $builder->join('streets', 'streets.id = plots.street_id', 'left');
        $query = $builder->get();
        return $query->getResultArray();
    }
}

<?php

namespace App\Controllers;

use App\Models\ApplicationsModel;

class Api extends BaseController
{
    protected $applicationsModel;

    public function __construct()
    {
        $this->applicationsModel = new ApplicationsModel();
    }

    public function searchApplications()
    {
        $q = trim($this->request->getGet('q'));
        $results = [];
        // print_r($q); // Debug log

        if ($q !== '') {
            try {
                $builder = $this->applicationsModel->db->table('applications a');
                $builder->select('a.id, a.app_no, a.customer_id, u.plot_no, bl.name as project_name, 
                            c.name as customer_name, c.cnic, p.total_paid');
                $builder->join('plots u', 'u.id = a.plot_id');
                $builder->join('projects bl', 'bl.id = a.project_id');
                $builder->join('customers c', 'c.id = a.customer_id');
                $builder->join(
                    '(SELECT application_id, SUM(paid_amount) as total_paid FROM payments GROUP BY application_id) p',
                    'p.application_id = a.id',
                    'left'
                );
                $builder->groupStart()
                    ->like('a.app_no', $q, 'both')
                    ->orLike('c.name', $q, 'both')
                    ->orLike('c.cnic', $q, 'both')
                    ->groupEnd();

                $results = $builder->get()->getResultArray();

                print_r('debug', 'SQL Query: ' . $this->applicationsModel->db->getLastQuery()); // Debug SQL
                print_r('debug', 'Results count: ' . count($results)); // Debug count

            } catch (\Exception $e) {
                log_message('error', 'Application search error: ' . $e->getMessage());
                return $this->response->setJSON([
                    'error' => 'Search failed',
                    'message' => $e->getMessage(),
                    'query' => $q // Return the query for debugging
                ])->setStatusCode(500);
            }
        }

        return $this->response->setJSON($results);
    }
}

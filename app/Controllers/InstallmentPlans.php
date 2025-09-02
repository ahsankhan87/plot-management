<?php

namespace App\Controllers;

use App\Models\InstallmentPlansModel;
use App\Models\ProjectsModel;
use CodeIgniter\Controller;

class InstallmentPlans extends Controller
{
    public function __construct()
    {
        $this->model = new InstallmentPlansModel();
        helper('audit');
    }
    public function index()
    {
        $plans = $this->model->findAll();
        return view('installment_plans/index', ['plans' => $plans]);
    }

    public function create()
    {
        $projectsModel = new ProjectsModel();
        $projects = $projectsModel->findAll();
        return view('installment_plans/create', ['projects' => $projects]);
    }

    public function store()
    {
        $model = new InstallmentPlansModel();
        $data = [
            // 'project_id' => $this->request->getPost('project_id'),
            'name' => $this->request->getPost('name'),
            'tenure_months' => $this->request->getPost('tenure_months'),
            'down_payment_pct' => $this->request->getPost('down_payment_pct'),
            'markup_pct' => $this->request->getPost('markup_pct'),
            // 'schedule_rule_json' => $this->request->getPost('schedule_rule_json'),
        ];
        $model->insert($data);
        logAudit('CREATE', 'Installment Plan', $model->insertID(), $data);
        return redirect()->to('/installmentplans')->with('success', 'Installment Plan created successfully');
    }

    public function edit($id)
    {
        $model = new InstallmentPlansModel();
        $plan = $model->find($id);
        $projectsModel = new ProjectsModel();
        $projects = $projectsModel->findAll();
        return view('installment_plans/edit', ['plan' => $plan, 'projects' => $projects]);
    }

    public function update($id)
    {
        $model = new InstallmentPlansModel();
        $data = [
            // 'project_id' => $this->request->getPost('project_id'),
            'name' => $this->request->getPost('name'),
            'tenure_months' => $this->request->getPost('tenure_months'),
            'down_payment_pct' => $this->request->getPost('down_payment_pct'),
            'markup_pct' => $this->request->getPost('markup_pct'),
            // 'schedule_rule_json' => $this->request->getPost('schedule_rule_json'),
        ];
        $model->update($id, $data);
        logAudit('UPDATE', 'Installment Plan', $id, $data);
        return redirect()->to('/installmentplans')->with('success', 'Installment Plan updated successfully');
    }

    public function delete($id)
    {
        $model = new InstallmentPlansModel();
        $model->delete($id);
        logAudit('DELETE', 'Installment Plan', $id, []);
        return redirect()->to('/installmentplans')->with('success', 'Installment Plan deleted successfully');
    }
}

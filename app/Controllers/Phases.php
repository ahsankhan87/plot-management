<?php

namespace App\Controllers;

use App\Models\PhaseModel;
use App\Models\ProjectsModel;

class Phases extends BaseController
{
    public function __construct()
    {
        $this->model = new PhaseModel();
        helper(['form', 'url', 'audit']);
    }

    public function index()
    {
        $data['phases'] = $this->model->getWithProject();
        return view('phases/index', $data);
    }

    public function create()
    {
        $projectsModel = new ProjectsModel();
        $data['projects'] = $projectsModel->findAll();
        return view('phases/create', $data);
    }

    public function save()
    {
        $this->model->save([
            'project_id' => $this->request->getPost('project_id'),
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ]);
        logAudit('CREATE', 'Phase', $this->model->insertID(), [], $this->request->getPost());
        return redirect()->to('/phases');
    }

    public function store()
    {
        $this->model->insert([
            'project_id' => $this->request->getPost('project_id'),
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description') ?? '',
        ]);
        logAudit('CREATE', 'Phase', $this->model->insertID(), [], $this->request->getPost());
        return $this->response->setJSON(['status' => 'success']);
    }
    public function edit($id)
    {
        $data['phase'] = $this->model->find($id);
        $projectsModel = new ProjectsModel();
        $data['projects'] = $projectsModel->findAll();
        return view('phases/edit', $data);
    }
    public function update($id)
    {
        $this->model->update($id, [
            'project_id' => $this->request->getPost('project_id'),
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ]);
        logAudit('UPDATE', 'Phase', $id, [], $this->request->getPost());
        return redirect()->to('/phases')->with('success', 'Phase updated successfully.');
    }

    public function listByProject($projectId)
    {
        return $this->response->setJSON($this->model->where('project_id', $projectId)->findAll());
    }

    public function getByProject($project_id)
    {
        $data = $this->model->where('project_id', $project_id)->findAll();
        return $this->response->setJSON($data);
    }
    public function delete($id)
    {
        $this->model->delete($id);
        logAudit('DELETE', 'Phase', $id);
        return redirect()->to('/phases')->with('success', 'Phase deleted successfully.');
    }
}

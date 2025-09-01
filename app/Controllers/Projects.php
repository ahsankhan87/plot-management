<?php

namespace App\Controllers;

use App\Models\ProjectsModel;

class Projects extends BaseController
{
    public function __construct()
    {
        $this->model = new ProjectsModel();
        helper(['audit', 'form', 'auth']);
    }
    public function index()
    {
        $projects = $this->model->findAll();
        return view('projects/index', ['projects' => $projects]);
    }

    public function create()
    {
        return view('projects/create');
    }

    public function save()
    {
        $model = new ProjectsModel();
        $model->save([
            'name' => $this->request->getPost('name'),
            'location' => $this->request->getPost('location'),

        ]);
        logAudit('CREATE', 'Project', $model->insertID(), [], $this->request->getPost());
        return redirect()->to('/projects')->with('success', 'Project created successfully.');
    }
    public function edit($id)
    {
        $project = $this->model->find($id);
        return view('projects/edit', ['project' => $project]);
    }

    public function update($id)
    {
        $this->model->update($id, [
            'name' => $this->request->getPost('name'),
            'location' => $this->request->getPost('location'),
        ]);
        logAudit('UPDATE', 'Project', $id, [], $this->request->getPost());
        return redirect()->to('/projects')->with('success', 'Project updated successfully.');
    }

    public function store()
    {
        $this->model->insert([
            'name' => $this->request->getPost('name'),
            'location' => $this->request->getPost('location'),
        ]);
        logAudit('CREATE', 'Project', $this->model->insertID(), [], $this->request->getPost());
        return $this->response->setJSON(['status' => 'success']);
    }

    public function listByProject($projectId)
    {
        $projectModel = new ProjectsModel();
        return $this->response->setJSON($projectModel->where('project_id', $projectId)->findAll());
    }

    public function delete($id)
    {
        $this->model->delete($id);
        logAudit('DELETE', 'Project', $id);
        return redirect()->to('/projects')->with('success', 'Project deleted successfully.');
    }
}

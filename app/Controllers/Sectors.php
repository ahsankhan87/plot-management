<?php

namespace App\Controllers;

use App\Models\SectorModel;
use App\Models\PhaseModel;

class Sectors extends BaseController
{
    public function __construct()
    {
        $this->model = new SectorModel();
        helper(['form', 'url', 'audit']);
    }
    public function index()
    {
        $data['sectors'] = $this->model->getWithPhase();
        return view('sectors/index', $data);
    }

    public function create()
    {

        $data['phases'] = $this->model->getWithPhase();
        return view('sectors/create', $data);
    }

    public function save()
    {
        $this->model->save([
            'phase_id' => $this->request->getPost('phase_id'),
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ]);
        logAudit('CREATE', 'Sector', $this->model->insertID(), [], $this->request->getPost());
        return redirect()->to('/sectors');
    }
    public function edit($id)
    {
        $data['sector'] = $this->model->find($id);
        $data['phases'] = $this->model->getWithPhase();
        return view('sectors/edit', $data);
    }
    public function update($id)
    {
        $this->model->update($id, [
            'phase_id' => $this->request->getPost('phase_id'),
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ]);
        logAudit('UPDATE', 'Sector', $id, [], $this->request->getPost());
        return redirect()->to('/sectors')->with('success', 'Sector updated successfully.');
    }

    public function store()
    {
        $this->model->insert([
            'phase_id' => $this->request->getPost('phase_id'),
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ]);
        logAudit('CREATE', 'Sector', $this->model->insertID(), [], $this->request->getPost());
        return $this->response->setJSON(['status' => 'success']);
    }

    public function listByPhase($phaseId)
    {
        return $this->response->setJSON($this->model->where('phase_id', $phaseId)->findAll());
    }
    public function getByPhase($phase_id)
    {
        $data = $this->model->where('phase_id', $phase_id)->findAll();
        return $this->response->setJSON($data);
    }
    public function delete($id)
    {
        $this->model->delete($id);
        logAudit('DELETE', 'Sector', $id);
        return redirect()->to('/sectors')->with('success', 'Sector deleted successfully.');
    }
}

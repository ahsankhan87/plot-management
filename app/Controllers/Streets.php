<?php

namespace App\Controllers;

use App\Models\StreetModel;
use App\Models\SectorModel;

class Streets extends BaseController
{
    public function __construct()
    {
        $this->model = new StreetModel();
        helper(['form', 'url', 'audit']);
    }

    public function index()
    {
        $data['streets'] = $this->model->getWithSector();
        return view('streets/index', $data);
    }

    public function create()
    {
        $data['sectors'] = $this->model->getWithSector();
        return view('streets/create', $data);
    }

    public function save()
    {
        $this->model->save([
            'sector_id' => $this->request->getPost('sector_id'),
            'street_no' => $this->request->getPost('street_no'),
            'description' => $this->request->getPost('description'),
        ]);
        logAudit('CREATE', 'Street', $this->model->insertID(), [], $this->request->getPost());
        return redirect()->to('/streets')->with('success', 'Street created successfully.');
    }
    public function store()
    {
        $this->model->insert([
            'sector_id' => $this->request->getPost('sector_id'),
            'street_no' => $this->request->getPost('street_no'),
            'description' => $this->request->getPost('description'),
        ]);
        logAudit('CREATE', 'Street', $this->model->insertID(), [], $this->request->getPost());
        return $this->response->setJSON(['status' => 'success']);
    }

    public function edit($id)
    {
        $data['street'] = $this->model->find($id);
        $data['sectors'] = $this->model->getWithSector();

        return view('streets/edit', $data);
    }

    public function update($id)
    {
        $this->model->update($id, [
            'sector_id' => $this->request->getPost('sector_id'),
            'street_no' => $this->request->getPost('street_no'),
            'description' => $this->request->getPost('description'),
        ]);
        logAudit('UPDATE', 'Street', $id, [], $this->request->getPost());
        return redirect()->to('/streets')->with('success', 'Street updated successfully.');
    }

    public function listBySector($sectorId)
    {
        return $this->response->setJSON($this->model->where('sector_id', $sectorId)->findAll());
    }

    public function getBySector($sector_id)
    {
        $data = $this->model->where('sector_id', $sector_id)->findAll();
        return $this->response->setJSON($data);
    }
    public function delete($id)
    {
        $this->model->delete($id);
        logAudit('DELETE', 'Street', $id);
        return redirect()->to('/streets')->with('success', 'Street deleted successfully.');
    }
}

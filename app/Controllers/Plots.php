<?php

namespace App\Controllers;

use App\Models\PlotsModel;
use App\Models\BlocksModel;
use App\Models\ProjectsModel;
use App\Models\PhaseModel;
use App\Models\SectorModel;
use App\Models\StreetModel;
use CodeIgniter\Controller;

class Plots extends Controller
{
    protected $plotModel;
    protected $blockModel;

    public function __construct()
    {
        $this->plotModel = new PlotsModel();
        $this->blockModel = new BlocksModel();
        $this->projectModel = new ProjectsModel();
        $this->phaseModel = new PhaseModel();
        $this->sectorModel = new SectorModel();
        $this->streetModel = new StreetModel();
        helper('form', 'url', 'audit');
        helper('audit');
    }

    public function index()
    {
        //permission
        // Usage in controllers:
        // if (!user_has_permission('manage_users')) {
        //     return redirect()->to('/dashboard')->with('error', 'Access Denied');
        // }

        $data['title'] = 'Plots List';
        $data['plots'] = $this->plotModel->findAll();

        return view('plots/index', $data);
    }

    public function create()
    {
        $data['projects'] = $this->projectModel->findAll();
        $data['phases'] = $this->phaseModel->findAll();
        $data['sectors'] = $this->sectorModel->findAll();
        $data['streets'] = $this->streetModel->findAll();
        $data['blocks'] = $this->blockModel->findAll();

        return view('plots/create', $data);
    }

    public function store()
    {
        $data = $this->request->getPost();
        // print_r($data);
        // echo $data['block_id'];
        // die();
        if (! $this->validateData($data, [
            // Validation rules

            'plot_no'   => 'required|is_unique[plots.plot_no]',
            'project_id' => 'permit_empty',
            'phase_id'  => 'permit_empty',
            'sector_id'  => 'permit_empty',
            'street_id' => 'required|numeric',
            'block_id'  => 'required',
            'size'      => 'required',
            'area_sqft' => 'required|numeric',
            'status' => 'required|in_list[available,booked,allotted,transferred,cancelled]',
            'type'      => 'permit_empty',
            'base_price' => 'permit_empty|numeric',

        ])) {
            return view('plots/create', [
                'validation' => $this->validator,
                'projects'   => $this->projectModel->findAll(),
                'phases'     => $this->phaseModel->findAll(),
                'sectors'    => $this->sectorModel->findAll(),
                'streets'    => $this->streetModel->findAll(),
                'blocks'     => $this->blockModel->findAll(),
            ]);
        }

        $this->plotModel->save([
            'plot_no'   => $data['plot_no'],
            'project_id' => $data['project_id'],
            'phase_id'   => $data['phase_id'],
            'sector_id'  => $data['sector_id'],
            'street_id' => $data['street_id'],
            'block_id'     => $data['block_id'],
            'size'      => $data['size'],
            'area_sqft' => $data['area_sqft'],
            'base_price' => $data['base_price'],
            'status'    => $data['status'] ?? 'available',
            'type'      => $data['type'] ?? 'residential',
        ]);

        logAudit('CREATE', 'Plots', $this->plotModel->insertID(), [], $data);

        return redirect()->to('/plots')->with('success', 'Plot created successfully!');
    }

    public function edit($id)
    {
        $data['plot'] = $this->plotModel->find($id);
        return view('plots/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'plot_no'   => 'required',
            //'block_id'     => 'required',
            'size'      => 'required',
            'area_sqft' => 'required|numeric',
            'base_price' => 'required|numeric',
            'type'      => 'permit_empty',
        ];

        if ($this->validate($rules)) {
            $this->plotModel->update($id, [
                'plot_no'   => $this->request->getPost('plot_no'),
                //'block_id'     => $this->request->getVar('block_id'),
                'size'      => $this->request->getPost('size'),
                'area_sqft' => $this->request->getPost('area_sqft'),
                'base_price' => $this->request->getPost('base_price'),
                'type'      => $this->request->getPost('type'),
            ]);

            logAudit('UPDATE', 'Plots', $id, $this->plotModel->find($id), $this->request->getPost());

            return redirect()->to('/plots')->with('success', 'Plot updated successfully!');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function delete($id)
    {
        if ($this->plotModel->delete($id)) {
            logAudit('DELETE', 'Plots', $id, $this->plotModel->find($id), []);
            return redirect()->to('/plots')->with('success', 'Plot deleted successfully');
        }

        return redirect()->to('/plots')->with('error', 'Failed to delete plot');
    }
    public function getByStreet($street_id)
    {
        $plots = $this->plotModel->where('street_id', $street_id)->where('status', 'available')->findAll();
        return $this->response->setJSON($plots);
    }

    // AJAX endpoint for plot status update
    public function updateStatus()
    {
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');

        if ($this->plotModel->update($id, ['status' => $status])) {
            logAudit('UPDATE_STATUS', 'Plots', $id, [], ['status' => $status]);
            return $this->response->setJSON(['success' => true]);
        }

        return $this->response->setJSON(['success' => false]);
    }
}

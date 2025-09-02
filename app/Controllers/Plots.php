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
        $this->validation = \Config\Services::validation();
        helper(['form', 'url', 'audit', 'auth']);
    }

    public function index()
    {
        if (!auth()->user()->can('plot_view')) {
            return view('errors/no_access');
        }

        $data['title'] = 'Plots List';
        $data['plots'] = $this->plotModel->getAllPlots();

        return view('plots/index', $data);
    }

    public function create()
    {
        if (!auth()->user()->can('plot_create')) {
            return view('errors/no_access');
        }
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

        // die();
        if (! $this->validateData($data, [
            // Validation rules

            'plot_no'   => 'required|is_unique[plots.plot_no]',
            'project_id' => 'required',
            'phase_id'  => 'required',
            'sector_id'  => 'required',
            'street_id' => 'required|numeric',
            'block_id'  => 'permit_empty',
            'size'      => 'required',
            'area_sqft' => 'required|numeric',
            'status' => 'required|in_list[available,booked,allotted,transferred,cancelled]',
            'type'      => 'permit_empty',
            'base_price' => 'permit_empty|numeric',
            'facing'    => 'permit_empty|in_list[north,south,east,west]',

        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
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
            'status'    => $data['status'] ?? 'Available',
            'type'      => $data['type'] ?? 'Residential',
            'facing'    => $data['facing'] ?? 'North',
        ]);

        logAudit('CREATE', 'Plots', $this->plotModel->insertID(), [], $data);

        return redirect()->to('/plots')->with('success', 'Plot created successfully!');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('plot_edit')) {
            return view('errors/no_access');
        }
        $data['plot'] = $this->plotModel->find($id);
        $data['projects'] = $this->projectModel->findAll();
        $data['phases'] = $this->phaseModel->findAll();
        $data['sectors'] = $this->sectorModel->findAll();
        $data['streets'] = $this->streetModel->findAll();
        $data['blocks'] = $this->blockModel->findAll();

        return view('plots/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'plot_no'   => 'required',
            //'block_id'     => 'required',
            'project_id' => 'required',
            'phase_id'  => 'required',
            'sector_id'  => 'required',
            'street_id' => 'required|numeric',
            'size'      => 'required',
            'area_sqft' => 'required|numeric',
            'base_price' => 'required|numeric',
            'type'      => 'permit_empty',
            'facing'    => 'permit_empty|in_list[north,south,east,west]',
        ];

        if ($this->validate($rules)) {
            $this->plotModel->update($id, [
                'plot_no'   => $this->request->getPost('plot_no'),
                'project_id' => $this->request->getPost('project_id'),
                'phase_id'   => $this->request->getPost('phase_id'),
                'sector_id'  => $this->request->getPost('sector_id'),
                'street_id' => $this->request->getPost('street_id'),
                //'block_id'     => $this->request->getVar('block_id'),
                'size'      => $this->request->getPost('size'),
                'area_sqft' => $this->request->getPost('area_sqft'),
                'base_price' => $this->request->getPost('base_price'),
                'type'      => $this->request->getPost('type'),
                'facing'    => $this->request->getPost('facing'),
            ]);

            logAudit('UPDATE', 'Plots', $id, $this->plotModel->find($id), $this->request->getPost());

            return redirect()->to('/plots')->with('success', 'Plot updated successfully!');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    }
    public function view($id)
    {
        if (!auth()->user()->can('plot_view')) {
            return view('errors/no_access');
        }

        $data['plot'] = $this->plotModel->getPlotDetails($id);
        return view('plots/view', $data);
    }

    public function delete($id)
    {
        if (!auth()->user()->can('plot_delete')) {
            return view('errors/no_access');
        }
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

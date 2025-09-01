<?php

namespace App\Controllers;

use App\Models\PermissionModel;

class Permission extends BaseController
{
    protected $permissionModel;
    protected $validation;

    public function __construct()
    {
        $this->permissionModel = new PermissionModel();
        $this->validation = \Config\Services::validation();
        helper('auth');
    }

    public function index()
    {
        if (!auth()->user()->can('permission_view')) {
            return view('errors/no_access');
        }
        $permissions = $this->permissionModel->findAll();
        return view('permission/index', ['permissions' => $permissions]);
    }

    public function create()
    {
        if (!auth()->user()->can('permission_create')) {
            return view('errors/no_access');
        }
        if ($this->request->getMethod() === 'POST') {
            $data = [
                'key' => $this->request->getPost('key'),
                'description' => $this->request->getPost('description')
            ];
            if ($this->permissionModel->insert($data)) {
                return redirect()->to('/permission')->with('success', 'Permission created successfully.');
            }
            return redirect()->back()->withInput()->with('errors', $this->permissionModel->errors());
        }
        return view('permission/create');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('permission_edit')) {
            return view('errors/no_access');
        }
        $permission = $this->permissionModel->find($id);
        if (!$permission) return redirect()->to('/permission')->with('error', 'Permission not found.');
        if ($this->request->getMethod() === 'POST') {
            $data = [
                'key' => $this->request->getPost('key'),
                'description' => $this->request->getPost('description')
            ];
            if ($this->permissionModel->update($id, $data)) {
                return redirect()->to('/permission')->with('success', 'Permission updated successfully.');
            }
            return redirect()->back()->withInput()->with('errors', $this->permissionModel->errors());
        }
        return view('permission/edit', ['permission' => $permission]);
    }

    public function delete($id)
    {
        if (!auth()->user()->can('permission_delete')) {
            return view('errors/no_access');
        }
        if ($this->permissionModel->delete($id)) {
            return redirect()->to('/permission')->with('success', 'Permission deleted successfully.');
        }
        return redirect()->to('/permission')->with('error', 'Failed to delete permission.');
    }
}

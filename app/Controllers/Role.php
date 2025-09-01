<?php

namespace App\Controllers;

use App\Models\RoleModel;
use App\Models\PermissionModel;

class Role extends BaseController
{
    protected $roleModel;
    protected $permissionModel;
    protected $validation;

    public function __construct()
    {
        $this->roleModel = new RoleModel();
        $this->permissionModel = new PermissionModel();
        $this->validation = \Config\Services::validation();
        helper('auth');
        helper('audit');
    }

    public function index()
    {
        if (!auth()->user()->can('role_view')) {
            return view('errors/no_access');
        }
        $roles = $this->roleModel->findAll();
        return view('role/index', ['roles' => $roles]);
    }

    public function create()
    {
        if (!auth()->user()->can('role_create')) {
            return view('errors/no_access');
        }
        if ($this->request->getMethod() === 'POST') {
            $data = [
                'name' => $this->request->getPost('name'),
                'description' => $this->request->getPost('description')
            ];
            $this->roleModel->save($data);
            logAudit('CREATE', 'Role', $this->roleModel->insertID(), [], $this->request->getPost());
            return redirect()->to('/role')->with('success', 'Role created successfully.');
        }
        return view('role/create');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('role_edit')) {
            return view('errors/no_access');
        }
        $role = $this->roleModel->find($id);
        if (!$role) return redirect()->to('/role')->with('error', 'Role not found.');
        if ($this->request->getMethod() === 'POST') {
            $data = [
                'name' => $this->request->getPost('name'),
                'description' => $this->request->getPost('description')
            ];
            $this->roleModel->update($id, $data);
            logAudit('UPDATE', 'Role', $id, $this->roleModel->find($id), $this->request->getPost());
            return redirect()->to('/role')->with('success', 'Role updated successfully.');
        }
        return view('role/edit', ['role' => $role]);
    }

    public function delete($id)
    {
        if (!auth()->user()->can('role_delete')) {
            return view('errors/no_access');
        }
        logAudit('DELETE', 'Role', $id, $this->roleModel->find($id), []);
        if ($this->roleModel->delete($id)) {
            return redirect()->to('/role')->with('success', 'Role deleted successfully.');
        }
        return redirect()->to('/role')->with('error', 'Failed to delete role.');
    }

    public function assignPermissions($id)
    {
        if (!auth()->user()->can('role_assign_permissions')) {
            return view('errors/no_access');
        }

        $role = $this->roleModel->find($id);
        $permissions = $this->permissionModel->findAll();
        $assigned = $this->permissionModel->getPermissionsByRole($id);
        if ($this->request->getMethod() === 'POST') {
            $selected = $this->request->getPost('permissions') ?? [];
            $db = \Config\Database::connect();
            $db->table('permission_role')->where('role_id', $id)->delete();
            foreach ($selected as $permName) {
                $perm = $this->permissionModel->where('key', $permName)->first();
                if ($perm) {
                    $db->table('permission_role')->insert([
                        'role_id' => $id,
                        'permission_id' => $perm['id']
                    ]);
                }
            }
            return redirect()->to('/role')->with('success', 'Permissions assigned.');
        }
        return view('role/assign_permissions', ['role' => $role, 'permissions' => $permissions, 'assigned' => $assigned]);
    }
}

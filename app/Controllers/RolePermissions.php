<?php

namespace App\Controllers;

use App\Models\RoleModel;
use App\Models\PermissionModel;
use App\Models\RolePermissionModel;

class RolePermissions extends BaseController
{
    public function assign($role_id)
    {
        $roleModel = new RoleModel();
        $permModel = new PermissionModel();
        $rolePermModel = new RolePermissionModel();

        $role = $roleModel->find($role_id);
        $permissions = $permModel->findAll();
        $assigned = $rolePermModel->where('role_id', $role_id)->findAll();

        $assigned_ids = array_column($assigned, 'permission_id');

        return view('roles/assign_permissions', [
            'role' => $role,
            'permissions' => $permissions,
            'assigned_ids' => $assigned_ids
        ]);
    }

    public function save($role_id)
    {
        $rolePermModel = new RolePermissionModel();
        $selected = $this->request->getPost('permissions') ?? [];

        // delete old
        $rolePermModel->where('role_id', $role_id)->delete();

        // insert new
        foreach ($selected as $perm_id) {
            $rolePermModel->insert([
                'role_id' => $role_id,
                'permission_id' => $perm_id
            ]);
        }

        return redirect()->to('/roles');
    }
}

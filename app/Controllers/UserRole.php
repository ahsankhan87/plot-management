<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RoleModel;

class UserRole extends BaseController
{
    protected $userModel;
    protected $roleModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
    }

    public function index()
    {
        if (!auth()->user()->can('userrole.view')) {
            return view('errors/no_access');
        }
        $users = $this->userModel->findAll();
        $roles = $this->roleModel->findAll();
        return view('user_role/index', ['users' => $users, 'roles' => $roles]);
    }

    public function updateRole()
    {
        if (!auth()->user()->can('userrole.update')) {
            return view('errors/no_access');
        }
        $userId = $this->request->getPost('user_id');
        $roleId = $this->request->getPost('role_id');
        if ($this->userModel->update($userId, ['role_id' => $roleId])) {
            return redirect()->to('/userrole')->with('success', 'User role updated successfully.');
        }
        return redirect()->back()->with('error', 'Failed to update user role.');
    }
}

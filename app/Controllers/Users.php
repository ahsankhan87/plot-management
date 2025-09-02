<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RoleModel;

class Users extends BaseController
{
    protected $userModel;
    protected $roleModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
        helper(['auth', 'audit']);
    }

    public function index()
    {
        if (!auth()->user()->can('users_view')) {
            return view('errors/no_access');
        }
        $data['title'] = "Users";

        $data['roles'] = $this->roleModel->findAll();
        $data['users'] = $this->userModel->select('users.*, roles.name as role')
            ->join('roles', 'roles.id=users.role_id', 'left')
            ->findAll();

        return view('users/index', $data);
    }

    public function create()
    {
        if (!auth()->user()->can('users_create')) {
            return view('errors/no_access');
        }
        $data['roles'] = $this->roleModel->findAll();
        $data['title'] = "Add User";
        return view('users/create', $data);
    }

    public function store()
    {
        $userModel = new UserModel();
        $userModel->save([
            'name'     => $this->request->getPost('name'),
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'role_id'  => $this->request->getPost('role_id'),
            'status'   => $this->request->getPost('status'),
        ]);
        logAudit('CREATE', 'Users', $userModel->insertID(), [], $this->request->getPost());
        return redirect()->to('/users')->with('success', 'User created successfully');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('users_edit')) {
            return view('errors/no_access');
        }
        $userModel = new UserModel();
        $roleModel = new RoleModel();
        $data['user'] = $userModel->find($id);
        $data['roles'] = $roleModel->findAll();
        $data['title'] = "Edit User";
        return view('users/edit', $data);
    }

    public function update($id)
    {
        $userModel = new UserModel();
        $data = [
            'name'    => $this->request->getPost('name'),
            'username' => $this->request->getPost('username'),
            'email'   => $this->request->getPost('email'),
            'role_id' => $this->request->getPost('role_id'),
            'status'  => $this->request->getPost('status'),
        ];
        if ($this->request->getPost('password')) {
            $data['password_hash'] = password_hash($this->request->getPost('password'), PASSWORD_BCRYPT);
        }
        $userModel->update($id, $data);
        logAudit('UPDATE', 'Users', $id, $userModel->find($id), $this->request->getPost());
        return redirect()->to('/users')->with('success', 'User updated successfully.');
    }

    public function delete($id)
    {
        if (!auth()->user()->can('users_delete')) {
            return view('errors/no_access');
        }
        $userModel = new UserModel();
        $insertResult = $userModel->delete($id);

        if ($insertResult) {
            logAudit('DELETE', 'Users', $id, $userModel->find($id), []);
            return redirect()->to('/users')->with('success', 'User deleted successfully.');
        } else {
            return redirect()->to('/users')->with('error', 'Failed to delete user.');
        }
    }

    public function updateRole()
    {
        $userId = $this->request->getPost('user_id');
        $roleId = $this->request->getPost('role_id');
        if ($this->userModel->update($userId, ['role_id' => $roleId])) {
            return redirect()->to('/users')->with('success', 'User role updated successfully.');
        }
        logAudit('UPDATE', 'Users', $userId, $this->userModel->find($userId), ['role_id' => $roleId]);
        return redirect()->back()->with('error', 'Failed to update user role.');
    }
}

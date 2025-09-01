<?php

namespace App\Controllers;

use App\Models\CompanyModel;
use App\Models\UserModel;
use App\Models\RoleModel;

class Setup extends BaseController
{
    protected $companyModel;
    protected $userModel;
    protected $roleModel;

    public function __construct()
    {
        $this->companyModel = new CompanyModel();
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
    }

    public function index()
    {
        // If setup is already complete, redirect to login
        if ($this->companyModel->isSetupComplete()) {
            return redirect()->to('login');
        }

        $data = [
            'validation' => \Config\Services::validation()
        ];

        return view('setup/index', $data);
    }

    public function process()
    {
        // If setup is already complete, redirect to login
        if ($this->companyModel->isSetupComplete()) {
            return redirect()->to('login');
        }

        $validationRules = [
            'company_name' => 'required|max_length[255]',
            'company_address' => 'required',
            'company_contact' => 'required|max_length[20]',
            'company_email' => 'required|valid_email|max_length[100]',
            'admin_fullname' => 'required|max_length[100]',
            'admin_username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
            'admin_email' => 'required|valid_email|max_length[100]|is_unique[users.email]',
            'admin_password' => 'required|min_length[5]',
            'admin_password_confirm' => 'required|matches[admin_password]'
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Start transaction
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // 1. Create company record
            $companyData = [
                'name' => $this->request->getPost('company_name'),
                'address' => $this->request->getPost('company_address'),
                'contact_number' => $this->request->getPost('company_contact'),
                'email' => $this->request->getPost('company_email'),
                'website' => $this->request->getPost('company_website'),
                'registration_number' => $this->request->getPost('company_reg_number'),
                'ntn' => $this->request->getPost('company_ntn'),
                'is_setup_complete' => 1,
                'setup_date' => date('Y-m-d H:i:s')
            ];

            $insertResult = $this->companyModel->insert($companyData);
            if ($insertResult === false) {
                $dbError = $db->error();
                $db->transRollback();
                throw new \Exception('Failed to create company: ' . implode(', ', $this->companyModel->errors()) . ' | DB Error: ' . ($dbError['message'] ?? ''));
            }

            // 2. Ensure admin role exists
            $adminRole = $this->roleModel->where('name', 'admin')->first();
            if (!$adminRole) {
                $insertResult = $this->roleModel->insert([
                    'name' => 'admin',
                    'description' => 'System Administrator with full access',
                    // 'permissions' => json_encode(['*']),
                    // 'is_active' => 1
                ]);
                $adminRoleId = $this->roleModel->getInsertID();
                if ($insertResult === false) {
                    $dbError = $db->error();

                    $db->transRollback();
                    throw new \Exception('Failed to create admin role: ' . implode(', ', $this->roleModel->errors()) . ' | DB Error: ' . ($dbError['message'] ?? ''));
                }
            }

            // 3. Create admin user
            $userData = [
                'username' => $this->request->getPost('admin_username'),
                'email' => $this->request->getPost('admin_email'),
                'password_hash' => password_hash($this->request->getPost('admin_password'), PASSWORD_DEFAULT),
                'name' => $this->request->getPost('admin_fullname'),
                'role_id' => $adminRole['id'] ?? $adminRoleId,
                'status' => 1
            ];

            $insertResult = $this->userModel->insert($userData);
            if ($insertResult === false) {
                $dbError = $db->error();
                $db->transRollback();
                throw new \Exception('Failed to create admin user: ' . implode(', ', $this->userModel->errors()) . ' | DB Error: ' . ($dbError['message'] ?? ''));
            }

            $db->transComplete();

            // Create upload directory
            if (!is_dir(ROOTPATH . 'public/uploads/company')) {
                mkdir(ROOTPATH . 'public/uploads/company', 0755, true);
            }
            if (!is_dir(ROOTPATH . 'public/uploads/customers')) {
                mkdir(ROOTPATH . 'public/uploads/customers', 0755, true);
            }

            return redirect()->to('login')->with('success', 'System setup completed successfully. You can now login with your admin credentials.');
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Setup failed: ' . $e->getMessage());
        }
    }

    public function checkSetup()
    {
        return $this->response->setJSON([
            'is_setup_complete' => $this->companyModel->isSetupComplete()
        ]);
    }
}

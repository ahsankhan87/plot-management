<?php

namespace App\Controllers;

use App\Models\CompanyModel;

class Company extends BaseController
{
    protected $companyModel;
    protected $validation;

    public function __construct()
    {
        $this->companyModel = new CompanyModel();
        $this->validation = \Config\Services::validation();
        helper(['auth', 'audit']);
    }

    public function index()
    {
        if (!auth()->user()->can('company_view')) {
            return view('errors/no_access');
        }

        $company = $this->companyModel->getCompany();

        $data = [
            'company' => $company,
            'validation' => $this->validation
        ];

        return view('company/index', $data);
    }

    public function update()
    {
        if (!auth()->user()->can('company_edit')) {
            return view('errors/no_access');
        }

        $rules = [
            'name' => 'required|max_length[255]',
            'address' => 'required',
            'contact_number' => 'required|max_length[20]',
            'email' => 'required|valid_email|max_length[100]',
            'logo' => 'max_size[logo,2048]|is_image[logo]|mime_in[logo,image/jpg,image/jpeg,image/png]',
            'registration_number' => 'max_length[100]',
            'ntn' => 'max_length[50]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $company = $this->companyModel->getCompany();
        $logoFile = $this->request->getFile('logo');
        $logoName = $company['logo'] ?? null;

        if ($logoFile->isValid() && !$logoFile->hasMoved()) {
            // Delete old logo if exists
            if ($logoName && file_exists(ROOTPATH . 'public/uploads/company/' . $logoName)) {
                unlink(ROOTPATH . 'public/uploads/company/' . $logoName);
            }

            $logoName = $logoFile->getRandomName();
            $logoFile->move(ROOTPATH . 'public/uploads/company', $logoName);
        }

        $companyData = [
            'name' => $this->request->getPost('name'),
            'address' => $this->request->getPost('address'),
            'contact_number' => $this->request->getPost('contact_number'),
            'email' => $this->request->getPost('email'),
            'website' => $this->request->getPost('website'),
            'registration_number' => $this->request->getPost('registration_number'),
            'ntn' => $this->request->getPost('ntn'),
            'tagline' => $this->request->getPost('tagline'),
            'bank_account_details' => $this->request->getPost('bank_account_details'),
            'logo' => $logoName
        ];

        $this->companyModel->update(1, $companyData);
        logAudit('UPDATE', 'Company', 1, $this->companyModel->find(1), $this->request->getPost());

        return redirect()->to('/company')->with('success', 'Company profile updated successfully.');
    }
}

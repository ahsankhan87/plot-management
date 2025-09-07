<?php

namespace App\Controllers;

use App\Models\CustomersModel;
use CodeIgniter\Controller;

class Customers extends Controller
{
    protected $customerModel;

    public function __construct()
    {
        $this->customerModel = new CustomersModel();
        $this->validation = \Config\Services::validation();
        helper('audit');
        helper('auth');
    }

    // List all customers
    public function index()
    {
        if (!auth()->user()->can('customers_view')) {
            return view('errors/no_access');
        }
        $data['title'] = 'Customers';
        $data['customers'] = $this->customerModel->findAll();
        return view('customers/index', $data);
    }

    public function detail($id)
    {
        if (!auth()->user()->can('customers_view')) {
            return view('errors/no_access');
        }
        $data['customer'] = $this->customerModel->find($id);
        if (!$data['customer']) {
            return redirect()->to('/customers')->with('error', 'Customer not found.');
        }
        return view('customers/detail', $data);
    }

    // Show create form
    public function create()
    {
        if (!auth()->user()->can('customers_create')) {
            return view('errors/no_access');
        }
        return view('customers/create');
    }

    // Store customer
    public function store()
    {
        $data = $this->request->getPost();

        if (! $this->validateData($data, [
            'name'        => 'required',
            'father_husband' => 'required',
            'cnic'        => 'required',
            'phone'       => 'required',
            'residential_address' => 'required',
            'nominee_name' => 'required',
            'nominee_relation' => 'required',
            'nominee_cnic' => 'required',
            'nominee_address' => 'required',
            'photo_path'  => 'permit_empty|uploaded[photo_path]|max_size[photo_path,2048]|is_image[photo_path]|mime_in[photo_path,image/jpg,image/jpeg,image/png]',
            'nominee_photo'  => 'permit_empty|uploaded[photo_path]|max_size[photo_path,2048]|is_image[photo_path]|mime_in[photo_path,image/jpg,image/jpeg,image/png]',
            'occupation' => 'permit_empty',
            'mobile' => 'permit_empty',
            'email' => 'permit_empty|valid_email',
            'postal_address' => 'permit_empty',
            'address' => 'permit_empty',
            'dob' => 'permit_empty|valid_date',
            'nominee_phone' => 'permit_empty',

        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }

        $photoFile = $this->request->getFile('photo_path');
        $photoName = null;
        if ($photoFile && $photoFile->isValid() && !$photoFile->hasMoved()) {
            $photoName = $photoFile->getRandomName();
            $photoFile->move(ROOTPATH . 'public/uploads/customers', $photoName);
        }

        $nomineePhotoFile = $this->request->getFile('nominee_photo');
        $nomineePhotoName = null;
        if ($nomineePhotoFile && $nomineePhotoFile->isValid() && !$nomineePhotoFile->hasMoved()) {
            $nomineePhotoName = $nomineePhotoFile->getRandomName();
            $nomineePhotoFile->move(ROOTPATH . 'public/uploads/customers', $nomineePhotoName);
        }

        // Save customer
        $this->customerModel->save([
            'name'        => $this->request->getPost('name'),
            'father_husband' => $this->request->getPost('father_husband'),
            'cnic'        => $this->request->getPost('cnic'),
            'phone'       => $this->request->getPost('phone'),
            'email'       => $this->request->getPost('email'),
            'postal_address' => $this->request->getPost('postal_address'),
            'residential_address' => $this->request->getPost('residential_address'),
            'nominee_name' => $this->request->getPost('nominee_name'),
            'nominee_relation' => $this->request->getPost('nominee_relation'),
            'nominee_cnic' => $this->request->getPost('nominee_cnic'),
            'nominee_address' => $this->request->getPost('nominee_address'),
            'photo_path' => $photoName,
            'address'     => $this->request->getPost('address'),
            'status'      => 'active',

            'nominee_photo'  => $nomineePhotoName,
            'occupation' => $this->request->getPost('occupation'),
            'mobile' => $this->request->getPost('mobile'),
            'dob' => $this->request->getPost('dob'),
            'nominee_phone' => $this->request->getPost('nominee_phone'),
        ]);
        // Log the audit
        logAudit('CREATE', 'Customers', $this->customerModel->insertID(), [], $this->request->getPost());
        return redirect()->to('/customers')->with('success', 'Customer created successfully.');
    }

    // Edit form
    public function edit($id)
    {
        if (!auth()->user()->can('customers_edit')) {
            return view('errors/no_access');
        }
        $data['customer'] = $this->customerModel->find($id);
        return view('customers/edit', $data);
    }

    // Update record
    public function update($id)
    {

        if (! $this->validateData($this->request->getPost(), [
            'name'        => 'required',
            'father_husband' => 'required',
            'cnic'        => 'required',
            'phone'       => 'required',
            'residential_address' => 'required',
            'nominee_name' => 'required',
            'nominee_relation' => 'required',
            'nominee_cnic' => 'required',
            'nominee_address' => 'required',
            'photo_path'  => 'permit_empty|uploaded[photo_path]|max_size[photo_path,2048]|is_image[photo_path]|mime_in[photo_path,image/jpg,image/jpeg,image/png]',
            'nominee_photo'  => 'permit_empty|uploaded[photo_path]|max_size[photo_path,2048]|is_image[photo_path]|mime_in[photo_path,image/jpg,image/jpeg,image/png]',
            'occupation' => 'permit_empty',
            'mobile' => 'permit_empty',
            'email' => 'permit_empty|valid_email',
            'postal_address' => 'permit_empty',
            'address' => 'permit_empty',
            'dob' => 'permit_empty|valid_date',
            'nominee_phone' => 'permit_empty',

        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }

        //customer photo
        $photoFile = $this->request->getFile('photo_path');
        $photoName = $this->customerModel->find($id)['photo_path'] ?? null;
        if ($photoFile && $photoFile->isValid() && !$photoFile->hasMoved()) {
            // Delete old photo if exists
            if ($photoName && file_exists(ROOTPATH . 'public/uploads/customers/' . $photoName)) {
                unlink(ROOTPATH . 'public/uploads/customers/' . $photoName);
            }
            $photoName = $photoFile->getRandomName();
            $photoFile->move(ROOTPATH . 'public/uploads/customers', $photoName);
        }

        //nominee photo
        $nomineePhotoFile = $this->request->getFile('nominee_photo');
        $nomineePhotoName = $this->customerModel->find($id)['nominee_photo'] ?? null;
        if ($nomineePhotoFile && $nomineePhotoFile->isValid() && !$nomineePhotoFile->hasMoved()) {
            // Delete old photo if exists
            if ($nomineePhotoName && file_exists(ROOTPATH . 'public/uploads/customers/' . $nomineePhotoName)) {
                unlink(ROOTPATH . 'public/uploads/customers/' . $nomineePhotoName);
            }
            $nomineePhotoName = $nomineePhotoFile->getRandomName();
            $nomineePhotoFile->move(ROOTPATH . 'public/uploads/customers', $nomineePhotoName);
        }

        $this->customerModel->update($id, [
            'name'        => $this->request->getPost('name'),
            'father_husband' => $this->request->getPost('father_husband'),
            'cnic'        => $this->request->getPost('cnic'),
            'phone'       => $this->request->getPost('phone'),
            'email'       => $this->request->getPost('email'),
            'postal_address' => $this->request->getPost('postal_address'),
            'residential_address' => $this->request->getPost('residential_address'),
            'nominee_name' => $this->request->getPost('nominee_name'),
            'nominee_relation' => $this->request->getPost('nominee_relation'),
            'nominee_cnic' => $this->request->getPost('nominee_cnic'),
            'nominee_address' => $this->request->getPost('nominee_address'),
            'photo_path' => $photoName,
            'address'     => $this->request->getPost('address'),

            'nominee_photo'  => $nomineePhotoName,
            'occupation' => $this->request->getPost('occupation'),
            'mobile' => $this->request->getPost('mobile'),
            'dob' => $this->request->getPost('dob'),
            'nominee_phone' => $this->request->getPost('nominee_phone'),

            // 'status'      => $this->request->getPost('status'),
        ]);
        // Log the audit
        logAudit('UPDATE', 'Customers', $id, $this->customerModel->find($id), $this->request->getPost());
        return redirect()->to('/customers')->with('success', 'Customer updated successfully.');
    }

    // Delete record
    public function delete($id)
    {
        if (!auth()->user()->can('customers_delete')) {
            return view('errors/no_access');
        }
        logAudit('DELETE', 'Customers', $id, $this->customerModel->find($id), []);
        $this->customerModel->delete($id);
        return redirect()->to('/customers')->with('success', 'Customer deleted successfully.');
    }
}

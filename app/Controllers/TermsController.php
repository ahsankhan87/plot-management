<?php

namespace App\Controllers;

use App\Models\TermsModel;

class TermsController extends BaseController
{
    public function __construct()
    {
        helper(['auth', 'audit']);
    }

    public function index()
    {
        $termsModel = new TermsModel();
        $terms = $termsModel->first();

        return view('terms/edit', ['terms' => $terms]);
    }

    public function update($id)
    {
        if (!auth()->user()->can('terms_edit')) {
            return view('errors/no_access');
        }

        if (!$this->request->getPost()) {
            return redirect()->to('/terms')->with('error', 'Invalid request method.');
        }
        $termsModel = new TermsModel();

        $data = [
            'title'   => $this->request->getPost('title'),
            'content' => $this->request->getPost('content')
        ];

        $termsModel->update($id, $data);
        logAudit('UPDATE', 'Terms & Conditions', $id, [], $data);

        return redirect()->to('/terms')->with('success', 'Terms & Conditions updated successfully!');
    }
}

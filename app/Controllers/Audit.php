<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AuditLogModel;

class Audit extends BaseController
{
    protected $auditModel;

    public function __construct()
    {
        $this->auditModel = new AuditLogModel();
    }

    public function index()
    {
        helper('auth');
        if (!auth()->user()->can('audit_view')) {
            return view('errors/no_access');
        }

        $logs = $this->auditModel->orderBy('created_at', 'DESC')->findAll();

        return view('audit/index', [
            'logs' => $logs
        ]);
    }

    public function delete($id)
    {
        logAudit('DELETE', 'Audit', $id, $this->auditModel->find($id), []);
        $this->auditModel->delete($id);
        return redirect()->to('/audit')->with('message', 'Log deleted successfully');
    }
}

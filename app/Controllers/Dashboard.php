<?php

namespace App\Controllers;

use App\Models\ApplicationsModel;
use App\Models\CustomersModel;
use App\Models\InstallmentModel;
use App\Models\PlotsModel;
use App\Models\PaymentModel;

class Dashboard extends BaseController
{
    protected $applicationModel;
    protected $plotModel;
    protected $paymentModel;
    protected $customerModel;
    protected $installmentModel;

    public function __construct()
    {
        $this->applicationModel = new ApplicationsModel();
        $this->plotModel = new PlotsModel();
        $this->paymentModel = new PaymentModel();
        $this->customerModel = new CustomersModel();
        $this->installmentModel = new InstallmentModel();
    }

    public function index()
    {
        // if (!session()->get('isLoggedIn')) {
        //     return redirect()->to('Auth/login');
        // }

        $data = [
            'title' => 'Dashboard',
            'latestPlots' => [],
            'latestApplications' => $this->getLatestApplications(),
            'overduePayments' => $this->getOverduePayments(),
            'totalApplications' => $this->applicationModel->countAllResults(),
            'totalPlots' => $this->plotModel->countAllResults(),
            'availablePlots' => $this->plotModel->where('status', 'available')->countAllResults(),
            'bookedPlots' => $this->plotModel->where('status', 'booked')->countAllResults(),
            'allottedPlots' => $this->plotModel->where('status', 'allotted')->countAllResults(),
            'transferredPlots' => $this->plotModel->where('status', 'transferred')->countAllResults(),
            'cancelledPlots' => $this->plotModel->where('status', 'cancelled')->countAllResults(),
            'totalCustomers' => $this->customerModel->countAllResults(),
        ];
        return view('dashboard/index', $data);
    }

    private function getLatestPlots()
    {
        return $this->plotModel->orderBy('created_at', 'DESC')->limit(5)->find();
    }

    private function getLatestApplications()
    {
        return $this->applicationModel->select('applications.*, customers.name as customer_name')
            ->join('customers', 'customers.id = applications.customer_id')
            ->orderBy('applications.created_at', 'DESC')->limit(5)->find();
    }

    private function getOverduePayments()
    {
        return $this->installmentModel->select('installments.*, customers.name as customer_name')
            ->join('applications', 'applications.id = installments.application_id')
            ->join('customers', 'customers.id = applications.customer_id')
            ->where('installments.status', 'pending')
            ->where('installments.due_date <', date('Y-m-d', strtotime('-1 months')))
            ->orderBy('due_date', 'ASC')->limit(5)->find();
    }
}

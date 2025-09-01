<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CompanyModel;

class SetupFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $companyModel = new CompanyModel();

        // If setup is not complete and we're not on the setup page, redirect to setup
        if (
            !$companyModel->isSetupComplete() &&
            !strpos(current_url(), 'setup') &&
            !strpos(current_url(), 'login')
        ) {
            return redirect()->to('setup');
        }

        // If setup is complete and we're on the setup page, redirect to login
        if ($companyModel->isSetupComplete() && strpos(current_url(), 'setup')) {
            return redirect()->to('login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}

<?php

use App\Models\CompanyModel;

if (!function_exists('company')) {
    function company($field = null)
    {
        $companyModel = new CompanyModel();
        $company = $companyModel->getCompany();

        if (!$company || !$company['is_setup_complete']) {
            return $field ? 'Not Set' : null;
        }

        if ($field) {
            return $company[$field] ?? 'N/A';
        }

        return $company;
    }
}

if (!function_exists('company_logo')) {
    function company_logo($class = 'h-8 w-auto')
    {
        $company = company();

        if ($company && $company['logo']) {
            return '<img src="' . base_url('uploads/company/' . $company['logo']) . '" 
                       alt="' . $company['name'] . '" 
                       class="' . $class . '">';
        }

        return '<div class="' . $class . ' bg-gray-200 rounded flex items-center justify-center text-gray-400 text-sm">No Logo</div>';
    }
}

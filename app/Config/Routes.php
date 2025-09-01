<?php

use App\Controllers\Permissions;
use App\Controllers\Plots;
use CodeIgniter\Router\RouteCollection;
use PHPUnit\TextUI\Configuration\LoggingNotConfiguredException;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Dashboard::index', ['filter' => 'auth']);
$routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth']);

$routes->get('reset-password/(:any)', 'Auth::resetPassword/$1');
$routes->post('reset-password/(:any)', 'Auth::resetPassword/$1');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::login');
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::register');
$routes->get('forgot-password', 'Auth::forgotPassword');
$routes->post('forgot-password', 'Auth::forgotPassword');
$routes->get('logout', 'Auth::logout');

$routes->group('customers', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Customers::index');
    $routes->get('detail/(:num)', 'Customers::detail/$1');
    $routes->get('create', 'Customers::create');
    $routes->post('store', 'Customers::store');
    $routes->get('edit/(:num)', 'Customers::edit/$1');
    $routes->post('update/(:num)', 'Customers::update/$1');
    $routes->get('delete/(:num)', 'Customers::delete/$1');
});

$routes->group('installments', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Installments::index');
    $routes->get('show/(:num)', 'Installments::show/$1');
    $routes->get('generate/(:num)', 'Installments::generate/$1');
    $routes->get('pay/(:num)', 'Installments::pay/$1');
    $routes->get('check-overdues', 'Installments::checkOverdues');
    $routes->post('pay-full-remaining/(:num)', 'Installments::payFullRemaining/$1');
    $routes->post('pay-custom-amount/(:num)', 'Installments::payCustomAmount/$1');
});
$routes->group('payments', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Payments::index');
    $routes->get('create/(:num)', 'Payments::create/$1');
    $routes->post('store/(:num)', 'Payments::store/$1');
    $routes->get('edit/(:num)', 'Payments::edit/$1');
    $routes->post('update/(:num)', 'Payments::update/$1');
    $routes->get('delete/(:num)', 'Payments::delete/$1');
    $routes->get('receipt/(:num)', 'Payments::receipt/$1');
    $routes->get('record/(:num)', 'Payments::record/$1');
    $routes->get('overdue', 'Payments::getOverduePayments');
});

$routes->group('applications', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Applications::index');
    $routes->get('create', 'Applications::create');
    $routes->post('store', 'Applications::store');
    $routes->get('edit/(:num)', 'Applications::edit/$1');
    $routes->post('update/(:num)', 'Applications::update/$1');
    $routes->get('delete/(:num)', 'Applications::delete/$1');
    $routes->delete('delete/(:num)', 'Applications::delete/$1');
    $routes->get('view/(:num)', 'Applications::view/$1');
    $routes->get('detail/(:num)', 'Applications::detail/$1');
    $routes->get('print-letter/(:num)/(:any)', 'Applications::printLetter/$1/$2');
});

$routes->group('plots', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Plots::index');
    $routes->get('create', 'Plots::create');
    $routes->post('store', 'Plots::store');
    $routes->get('edit/(:num)', 'Plots::edit/$1');
    $routes->post('update/(:num)', 'Plots::update/$1');
    $routes->get('delete/(:num)', 'Plots::delete/$1');
});

$routes->group('projects', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Projects::index');
    $routes->get('create', 'Projects::create');
    $routes->post('store', 'Projects::store');
    $routes->post('save', 'Projects::save');
    $routes->get('edit/(:num)', 'Projects::edit/$1');
    $routes->post('update/(:num)', 'Projects::update/$1');
    $routes->get('delete/(:num)', 'Projects::delete/$1');
});

$routes->group('phases', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Phases::index');
    $routes->get('create', 'Phases::create');
    $routes->post('store', 'Phases::store');
    $routes->post('save', 'Phases::save');
    $routes->get('edit/(:num)', 'Phases::edit/$1');
    $routes->post('update/(:num)', 'Phases::update/$1');
    $routes->get('delete/(:num)', 'Phases::delete/$1');
});
$routes->group('sectors', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Sectors::index');
    $routes->get('create', 'Sectors::create');
    $routes->post('store', 'Sectors::store');
    $routes->post('save', 'Sectors::save');
    $routes->get('edit/(:num)', 'Sectors::edit/$1');
    $routes->post('update/(:num)', 'Sectors::update/$1');
    $routes->get('delete/(:num)', 'Sectors::delete/$1');
});

$routes->group('streets', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Streets::index');
    $routes->get('create', 'Streets::create');
    $routes->post('store', 'Streets::store');
    $routes->post('save', 'Streets::save');
    $routes->get('edit/(:num)', 'Streets::edit/$1');
    $routes->post('update/(:num)', 'Streets::update/$1');
    $routes->get('delete/(:num)', 'Streets::delete/$1');
});

$routes->group('users', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Users::index');
    $routes->get('create', 'Users::create');
    $routes->post('store', 'Users::store');
    $routes->get('edit/(:num)', 'Users::edit/$1');
    $routes->post('update/(:num)', 'Users::update/$1');
    $routes->get('delete/(:num)', 'Users::delete/$1');
    $routes->get('user-role', 'Users::userRole');
    $routes->post('update-role', 'Users::updateRole');
});


$routes->group('audit', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Audit::index');
});

//no access route
$routes->get('errors/no_access', 'Errors::noAccess');


// Setup routes
$routes->get('setup', 'Setup::index');
$routes->post('setup/process', 'Setup::process');
$routes->get('setup/check', 'Setup::checkSetup');

// Company routes (single company)
$routes->get('company', 'Company::index', ['filter' => 'auth']);
$routes->post('company/update', 'Company::update', ['filter' => 'auth']);

// Cascading AJAX routes
$routes->get('phases/byProject/(:num)', 'Phases::getByProject/$1');
$routes->get('sectors/byPhase/(:num)', 'Sectors::getByPhase/$1');
$routes->get('streets/bySector/(:num)', 'Streets::getBySector/$1');
$routes->get('plots/byStreet/(:num)', 'Plots::getByStreet/$1');

$routes->group('role', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Role::index');
    $routes->get('create', 'Role::create');
    $routes->post('create', 'Role::create');
    $routes->get('edit/(:num)', 'Role::edit/$1');
    $routes->post('edit/(:num)', 'Role::edit/$1');
    $routes->get('delete/(:num)', 'Role::delete/$1');
    $routes->get('assignPermissions/(:num)', 'Role::assignPermissions/$1');
    $routes->post('assignPermissions/(:num)', 'Role::assignPermissions/$1');
});

$routes->group('permission', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Permission::index');
    $routes->get('create', 'Permission::create');
    $routes->post('create', 'Permission::create');
    $routes->get('edit/(:num)', 'Permission::edit/$1');
    $routes->post('edit/(:num)', 'Permission::edit/$1');
    $routes->get('delete/(:num)', 'Permission::delete/$1');
});

$routes->group('expenses', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Expenses::index');
    $routes->get('create', 'Expenses::create');
    $routes->post('store', 'Expenses::store');
    $routes->get('edit/(:num)', 'Expenses::edit/$1');
    $routes->post('update/(:num)', 'Expenses::update/$1');
    $routes->get('delete/(:num)', 'Expenses::delete/$1');
});

// Transfer routes
$routes->group('transfers', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Transfers::index');
    $routes->get('create', 'Transfers::create');
    $routes->get('create/(:num)', 'Transfers::create/$1');
    $routes->post('store', 'Transfers::store');
    $routes->get('view/(:num)', 'Transfers::view/$1');
    $routes->get('approve/(:num)', 'Transfers::approve/$1');
    $routes->post('reject/(:num)', 'Transfers::reject/$1');
    $routes->get('agreement/(:num)', 'Transfers::generateAgreement/$1');
});

// API routes
$routes->get('api/applications/search/', 'Api::searchApplications');
$routes->get('transfers/checkEligibility/(:num)', 'Transfers::checkEligibility/$1');
// --------------------------------------------------------------------
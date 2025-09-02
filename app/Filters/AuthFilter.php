<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    protected $publicRoutes = [
        'login',
        'register',
        'forgot-password',
        'reset-password',
        'logout',
        'api',
    ];

    public function before(RequestInterface $request, $arguments = null)
    {
        $uri = service('uri');
        $route = $uri->getSegment(1);

        // Skip authentication for public routes
        if (in_array($route, $this->publicRoutes)) {
            return;
        }

        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'You must be logged in to access this page.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}

<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        helper('audit'); // Load the audit helper for logging actions
        // Initialize the UserModel
        $this->userModel = new UserModel();
    }

    public function login()
    {
        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'username' => 'required',
                'password' => 'required|min_length[5]'
            ];
            // Validate the input
            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            $user = $this->userModel->select('users.*, roles.name as role')
                ->join('roles', 'roles.id=users.role_id', 'left')->where('users.username', $username)->first();

            if (!$user || !password_verify($password, $user['password_hash'])) {
                return redirect()->back()->withInput()->with('error', 'Invalid username or password');
            }

            if (!$user['status']) {
                return redirect()->back()->withInput()->with('error', 'Your account is inactive');
            }

            // Set user session
            $session = session();
            $session->set([
                'user_id' => $user['id'],
                'username' => $user['username'],
                'name' => $user['name'],
                'isLoggedIn' => true,
                'role_id' => $user['role_id'],
                'role' => $user['role']
            ]);

            // After login
            $result =  logAudit('LOGIN', 'Auth', session()->get('user_id'), [], ['username' => $user['username'], 'name' => $user['name']]);

            return redirect()->to('/')->with('message', 'Welcome back, ' . $result);
        }

        $data = [
            'title' => 'Login'
        ];

        return  view('auth/login', $data);
    }

    public function register()
    {
        if ($this->request->getMethod() === 'POST') {

            $rules = [
                'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[5]',
                'password_confirm' => 'required|matches[password]',
                'name' => 'required|min_length[3]'
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $data = [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
                'name' => $this->request->getPost('name'),
                'phone' => $this->request->getPost('phone'),
                'status' => 0 // Set to 0 if you want admin approval
            ];

            $this->userModel->save($data);
            // Log the registration action
            logAudit('registration', 'Auth', $this->userModel->insertID(), [], $data);
            //logAction('registration', 'New user registered: ' . $data['username'] . ' with email: ' . $data['email']);
            //
            // Redirect to login page with success message
            return redirect()->to('/login')->with('message', 'Registration successful! Please login.');
        }

        $data = [
            'title' => 'Register'
        ];

        return view('auth/register', $data);
    }

    public function forgotPassword()
    {
        if ($this->request->getMethod() === 'POST') {
            $rules = ['email' => 'required|valid_email'];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $email = $this->request->getPost('email');
            $user = $this->userModel->getUserByEmail($email);

            if (!$user) {
                return redirect()->back()->with('error', 'Email not found');
            }

            $token = $this->userModel->createResetToken($email);

            // In a real app, you would send an email here
            // For now, we'll just display the reset link
            $resetLink = base_url("reset-password/$token");
            // You can use a mailer library to send the reset link via email
            // For example, using CodeIgniter's email library:

            // Log the password reset request
            logAudit('PASSWORD_RESET_REQUEST', 'Auth', $user['id'], [], ['email' => $email]);
            //
            return redirect()->back()->with('message', "Password reset link: <a href='$resetLink'>$resetLink</a>");
        }

        $data = [
            'title' => 'Forgot Password'
        ];

        return view('auth/forgot_password', $data);
    }

    public function resetPassword($token = null)
    {
        if (!$token) {
            return redirect()->to('/forgot-password');
        }

        $user = $this->userModel->verifyResetToken($token);
        if (!$user) {
            return redirect()->to('/forgot-password')->with('error', 'Invalid or expired token');
        }

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'password' => 'required|min_length[6]',
                'password_confirm' => 'required|matches[password]'
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $this->userModel->update($user['id'], [
                'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
                'reset_token' => null,
                'reset_expires' => null
            ]);
            // Log the password reset action
            logAudit('PASSWORD_RESET', 'Auth', $user['id'], [], [
                'password_reset' => date('Y-m-d H:i:s')
            ]);

            return redirect()->to('/login')->with('message', 'Password reset successfully');
        }

        $data = [
            'title' => 'Reset Password',
            'token' => $token
        ];

        return view('auth/reset_password', $data);
    }

    public function logout()
    {
        // session()->remove(['user_id', 'username', 'name', 'is_logged_in', 'store_id']);
        // Log the logout action
        logAudit('LOGOUT', 'Auth', session()->get('user_id'), [], []);
        session()->destroy();
        return redirect()->to('/login')->with('message', 'You have been logged out');
    }
}

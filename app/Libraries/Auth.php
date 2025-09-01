<?php

namespace App\Libraries;

use App\Models\UserModel;
use App\Models\RoleModel;
use App\Models\PermissionModel;

class Auth
{
    protected static $instance;
    protected $user;
    protected $role;
    protected $permissions;

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct()
    {
        $session = session();
        $userId = $session->get('user_id');
        if ($userId) {
            $userModel = new UserModel();
            $this->user = $userModel->find($userId);
            if ($this->user) {
                $roleModel = new RoleModel();
                $this->role = $roleModel->find($this->user['role_id']);
                $permissionModel = new PermissionModel();
                $this->permissions = $permissionModel->getPermissionsByRole($this->user['role_id']);
            }
        }
    }

    public function user()
    {
        return $this;
    }

    public function can($permission)
    {
        // If user is admin, allow all
        if ($this->role && strtolower($this->role['name']) === 'admin') {
            return true;
        }
        if (empty($this->permissions)) return false;
        return in_array($permission, $this->permissions);
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getRole()
    {
        return $this->role;
    }
}

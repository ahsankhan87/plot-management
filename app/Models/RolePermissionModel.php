<?php

namespace App\Models;

use CodeIgniter\Model;

class RolePermissionModel extends Model
{
    protected $table = 'permission_role';
    protected $primaryKey = 'id';
    protected $allowedFields = ['role_id', 'permission_id'];
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class PermissionModel extends Model
{
    protected $table = 'permissions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['key', 'description'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';

    public function getPermissionsByRole($roleId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('permission_role');
        $builder->select('permissions.key');
        $builder->join('permissions', 'permissions.id = permission_role.permission_id');
        $builder->where('permission_role.role_id', $roleId);
        $query = $builder->get();
        $result = $query->getResultArray();
        return array_column($result, 'key');
    }
}

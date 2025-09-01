<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'username',
        'email',
        'password_hash',
        'name',
        'status',
        'phone',
        'role_id',
        'reset_token',
        'reset_expires'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';

    protected $returnType = 'array';
}

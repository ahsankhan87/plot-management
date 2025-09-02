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

    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }
    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    public function createResetToken($email)
    {
        $user = $this->where('email', $email)->first();
        if (!$user) {
            return false;
        }

        $token = bin2hex(random_bytes(16));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $this->update($user['id'], [
            'reset_token' => $token,
            'reset_expires' => $expires
        ]);

        return $token;
    }

    public function verifyResetToken($token)
    {
        return $this->where('reset_token', $token)
            ->where('reset_expires >', date('Y-m-d H:i:s'))
            ->first();
    }
}

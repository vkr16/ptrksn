<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'email';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields = ['name', 'email', 'password', 'role', 'status', 'nip', 'nik', 'instance', 'position'];
}

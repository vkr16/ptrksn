<?php

namespace App\Models;

use CodeIgniter\Model;

class TutorModel extends Model
{
    protected $table      = 'tutorials';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields = ['name', 'content'];
}

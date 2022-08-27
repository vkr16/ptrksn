<?php

namespace App\Models;

use CodeIgniter\Model;

class FileModel extends Model
{
    protected $table      = 'files';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields = ['document_name', 'file_name', 'project_id', 'user_id', 'uploaded_at'];
}

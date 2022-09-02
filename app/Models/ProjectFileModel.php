<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectFileModel extends Model
{
    protected $table      = 'project_files';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields = ['document_name', 'file_name', 'project_id', 'user_id', 'upload_time'];
}

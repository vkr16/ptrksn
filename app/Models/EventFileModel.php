<?php

namespace App\Models;

use CodeIgniter\Model;

class EventFileModel extends Model
{
    protected $table      = 'event_files';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields = ['document_name', 'file_name', 'event_id', 'user_id', 'upload_time'];
}

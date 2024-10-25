<?php

namespace App\Models;

use CodeIgniter\Model;

class SUserModel extends Model
{
    protected $table      = 's_user';
    protected $primaryKey = 'id_user';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['name', 'last_name', 'email', 'pass', 'picture', 'status', 'id_sede', 'req_actualizacion', 'created_by', 'created_at', 'last_modified_by', 'last_modified_at', 'deleted', 'is_admin'];

    //protected $useTimestamps = true;
    protected $createdField  = 'created_at';
   // protected $updatedField  = 'updated_at';
    //protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
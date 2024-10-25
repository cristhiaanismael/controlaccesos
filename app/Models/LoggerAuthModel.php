<?php
    namespace App\Models;
    use CodeIgniter\Model;
    
    class LoggerAuthModel extends Model
    {
        //idlogger_auth_cm, date, id_user, data, error_details
        protected $table      = 'logger_auth_cm';
        protected $primaryKey = 'idlogger_auth_cm';
    
        protected $useAutoIncrement = true;
    
        protected $returnType     = 'array';
        protected $useSoftDeletes = true;
    
        protected $allowedFields = ['date', 'id_user', 'data', 'details', 'type', 'action'];
    
        //protected $useTimestamps = true;
        //protected $createdField  = 'created_at';
        //protected $updatedField  = 'last_modified_at';
        //protected $deletedField  = 'deleted_at';
    
        protected $validationRules    = [];
        protected $validationMessages = [];
        protected $skipValidation     = false;
    }

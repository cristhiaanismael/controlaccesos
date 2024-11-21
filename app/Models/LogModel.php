<?php

namespace App\Models;

use CodeIgniter\Model;

class LogModel extends Model
{
    protected $table      = 'logs_scanner';
    protected $primaryKey = 'idlog_scanner';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    //protected $useSoftDeletes = true;

    protected $allowedFields = ['id_qr','date_scanner','type'];

   // protected $useTimestamps = true;
    protected $createdField  = 'date_scanner';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function __construct()
    {
        parent::__construct();
    }
   
    public function create($data){
        $res=false;
        $this->insert($data);
        $result=$this->insertID;
        if($result){
             $res=$result;
        }
        return $res;
    }
  
    public function readById($id_usuario){
        /*$query=$this->where('id_usuario', $id_usuario)
                    ->get();

        $res= $query->getResult();
        return $res;*/
    }


}
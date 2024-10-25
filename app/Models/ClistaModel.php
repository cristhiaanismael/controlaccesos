<?php

namespace App\Models;

use CodeIgniter\Model;

class ClistaModel extends Model
{
    protected $table      = 'c_lista';
    protected $primaryKey = 'id_lista';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    //protected $useSoftDeletes = true;

    protected $allowedFields = ['id_sede', 'id_program', 'nombre', 'script', 'is_dynamic','created_by', 'deleted', 'created_at', 'last_modified_by', 'last_modified_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'last_modified_at';
    //protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function __construct()
    {

        parent::__construct();
        

    }

   
    public function insert_data($data){
        $this->insert($data);
        $result=$this->insertID;
        if($result){
            return $result;
        }else{
            return false;
       }
    }
    public function delete_list($idlist){
        $this->where('id_lista', $idlist);
        $this->delete();
        $no = $this->affectedRows();
        return $no; 
    }

    




}
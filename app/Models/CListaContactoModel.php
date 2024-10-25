<?php

namespace App\Models;

use CodeIgniter\Model;

class CListaContactoModel extends Model
{
    protected $table      = 'c_lista_contacto';
    protected $primaryKey = 'id_lista_contacto';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = [ 'id_lista', 'titulo', 'nombre', 'apellidos', 'email', 'razon_social', 'puesto'];

    //protected $useTimestamps = true;
    //protected $createdField  = 'created_at';
   // protected $updatedField  = 'updated_at';
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
    public function get_rows($FirstID, $LastID){
        $query=$this->where('id_lista_contacto>=', $FirstID)
                    ->where('id_lista_contacto<=', $LastID)
                     ->get();
        $res= $query->getResult();
        return $res;
    }

    public function GetData($FirstID){
        $db = db_connect();
        var_dump($db);
        $db->where('id_lista_contacto>=', $FirstID);
        $query = getResultArray();
        var_dump($query);
    }
  

}
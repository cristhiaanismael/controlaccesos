<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'usuarios';
    protected $primaryKey = 'id_usuario';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    //protected $useSoftDeletes = true;

    protected $allowedFields = ['id_usuario', 'nombre', 'apellido_pat', 'apellido_mat', 'matricula', 'programa', 'identificador', 'aquien_v', 'priviende_de', 'motivo', 'n_empleado', 'area', 'tipo_usuario', 'created_by', 'modified_by', 'created_at', 'modified_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'modified_at';
    //protected $deletedField  = 'deleted_at';

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
    public function read($tipo_usuario){
        $query=$this->where('tipo_usuario', $tipo_usuario)
                    ->get();

        $res= $query->getResult();
        return $res;
    }
    public function delete_list($idlist){
        $this->where('', $idlist);
        $this->delete();
        $no = $this->affectedRows();
        return $no; 
    }

    




}
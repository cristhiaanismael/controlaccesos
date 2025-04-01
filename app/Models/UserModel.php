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


    public function readById($id_usuario){
        $query=$this->where('id_usuario', $id_usuario)
                    ->get();

        $res= $query->getResult();
        return $res;
    }
    public function readByIdIn($ids){
        
        $query = $this->whereIn('usuarios.id_usuario', $ids)
              ->join('cat_qr', 'cat_qr.id_usuario = usuarios.id_usuario')
              ->where('cat_qr.activo', 1)
              ->get();

        $res = $query->getResult();
        return $res;
    }
    public function readByIdentificador($identificador){ 
         $builder = $this->db->table('cat_qr qr')
        ->select('qr.id_qr as id_qr, qr.id_usuario as qr_id_usuario, activo, date_entry, 
                date_exit, hour_entry, hour_exit, idlog_scanner,
                 log.id_qr as log_id_qr, date_scanner, type,
                 us.id_usuario, nombre, apellido_pat, apellido_mat,
                  matricula, programa, identificador, aquien_v,
                   proviene_de, motivo, n_empleado, area, puesto, tipo_usuario')
        ->join('logs_scanner log', 'log.id_qr=qr.id_qr', 'left')
        ->join('usuarios us', 'us.id_usuario=qr.id_usuario')
        ->where('us.matricula', $identificador)
        ->orWhere('us.n_empleado', $identificador)
        ->where('qr.activo', '1')
        ->orderBy('log.idlog_scanner', 'desc')
        ->limit(1);

        $query = $builder->get();
        $codes = $query->getResult();
        return $codes;
    }
    public function delete_list($idlist){
        $this->where('', $idlist);
        $this->delete();
        $no = $this->affectedRows();
        return $no; 
    }
    public function insert_data($data)
{
    // Intentar insertar los datos en la tabla 'usuarios'
    $this->insert($data);

    // Si la inserción fue exitosa, devolver el ID insertado
    if ($this->insertID) {
        return $this->insertID;
    }

    // Si la inserción falló, devolver false
    return false;
}


}
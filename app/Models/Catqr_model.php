<?php

namespace App\Models;

use CodeIgniter\Model;

class Catqr_model extends Model
{
    protected $table      = 'cat_qr';
    protected $primaryKey = 'id_qr';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    //protected $useSoftDeletes = true;
    protected $allowedFields = ['id_qr', 'code', 'id_usuario', 'img', 'created_at', 'update_at', 'created_by', 'modified_by', 'activo', 'date_entry', 'date_exit', 'hour_entry', 'hour_exit'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'update_at';
    //protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    public $db;

    public function __construct()
    {
        parent::__construct();
         $this->db = \Config\Database::connect();
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
    public function get_active($id_usuario=false){

        $builder = $this->db->table('cat_qr')
            ->select('id_qr, code, id_usuario, img, activo,  date_entry, date_exit, hour_entry, hour_exit,created_at')
            ->where('id_usuario', $id_usuario)
            ->where('activo', '1');
        $query = $builder->get();
        $codes = $query->getResult();
        return $codes;
    }

    public function get_code($code){
        $builder = $this->db->table('cat_qr qr')
            ->select('qr.id_qr as id_qr, qr.id_usuario as qr_id_usuario, activo, date_entry, 
                    date_exit, hour_entry, hour_exit, idlog_scanner,
                     log.id_qr as log_id_qr, date_scanner, type,
                     us.id_usuario, nombre, apellido_pat, apellido_mat,
                      matricula, programa, identificador, aquien_v,
                       proviene_de, motivo, n_empleado, area, puesto, tipo_usuario, us.img as profile')
            ->join('logs_scanner log', 'log.id_qr=qr.id_qr', 'left')
            ->join('usuarios us', 'us.id_usuario=qr.id_usuario')
            ->where('code', $code)
            ->where('qr.activo', '1')
            ->orderBy('log.idlog_scanner', 'desc')
            ->limit(1);
        $query = $builder->get();
        //0$last_query =  $this->db->getLastQuery();
        $codes = $query->getResult();
        return $codes;
    }


    public function getById($id_usuario=[]){
        $builder = $this->db->table('cat_qr qr')
            ->select('qr.id_qr as id_qr, qr.id_usuario as qr_id_usuario, activo, qr.img,
                     us.id_usuario, nombre, apellido_pat, apellido_mat,
                      matricula, programa, identificador, aquien_v, us.img as foto,
                       proviene_de, motivo, n_empleado, area, puesto, tipo_usuario')
            ->join('usuarios us', 'us.id_usuario=qr.id_usuario')
            ->whereIn('qr.id_usuario', $id_usuario)
            ->where('qr.activo', '1');
        $query = $builder->get();
        $last_query =  $this->db->getLastQuery();
        $codes = $query->getResult();
        return $codes;
    }




    

    public function desactivar($id_usuario=false){
        $data = [
            'activo'  => 0,
        ];

        $builder = $this->db->table('cat_qr');
        $builder->where('id_usuario', $id_usuario);
        $builder->update($data);
            return true;
    }
 

    




}
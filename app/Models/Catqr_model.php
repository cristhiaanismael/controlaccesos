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
    public function get_active($where=false){

        $builder = $this->db->table('cat_qr')
            ->select('id_qr, code, id_usuario, img, activo,  date_entry, date_exit, hour_entry, hour_exit,created_at')
            ->where('id_usuario', $where['id_usuario'])
            ->where('activo', '1');
        $query = $builder->get();
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
<?php
namespace App\Models;
use CodeIgniter\Model;

class ImagenperfilModel extends Model
{
    protected $table      = 'imagen_perfil';
    protected $primaryKey = 'idimagen_perfil';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    //protected $useSoftDeletes = true;

    protected $allowedFields = ['idimagen_perfil', 'imagen_base64', 'id_usuario', 'activo', 'create_at'];

    //protected $useTimestamps = true;
    protected $createdField  = 'created_at';

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
}
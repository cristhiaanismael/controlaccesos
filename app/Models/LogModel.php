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

    public function usuariosDentro()
    {
                $sql = "SELECT log.*, idlog_scanner, log.id_qr, log.date_scanner, u.tipo_usuario, u.id_usuario, u.nombre,
                    apellido_pat, u.apellido_mat, u.matricula, u.programa, u.aquien_v,  u.motivo, u.area, u.tipo_usuario, tipo.nombre as tipo_user
                    FROM logs_scanner log
                    JOIN (
                        SELECT id_qr, MAX(date_scanner) AS last_date
                        FROM logs_scanner
                        WHERE DATE(date_scanner) = CURDATE() -- Filtra solo los registros del día actual
                        GROUP BY id_qr
                    ) AS latest ON log.id_qr = latest.id_qr AND log.date_scanner = latest.last_date
                    inner join cat_qr cat on
                    cat.id_qr=log.id_qr
                    inner join usuarios u
                    on u.id_usuario=cat.id_usuario
                    inner join tipos_usuario tipo
                    on tipo.idtipo_usuario=u.tipo_usuario
                    WHERE log.type = 'ENTRADA'";
                $query =   $this->db->query($sql);
            
                return $query->getResult();

    }
  
    public function movimientos($fecha){
        $sql = "SELECT log.*, idlog_scanner, log.id_qr, log.date_scanner, 
        u.tipo_usuario, u.id_usuario, u.nombre,
        apellido_pat, u.apellido_mat, u.matricula, u.programa, u.aquien_v,  
        u.motivo, u.area, u.tipo_usuario, tipo.nombre as tipo_user
        FROM logs_scanner log
        
        inner join cat_qr cat on
        cat.id_qr=log.id_qr
        inner join usuarios u
        on u.id_usuario=cat.id_usuario
        inner join tipos_usuario tipo
        on tipo.idtipo_usuario=u.tipo_usuario
        WHERE log.date_scanner like '$fecha%'";
    $query =   $this->db->query($sql);

    return $query->getResult();
    }


    public function resumen($fecha){
        $sql = "SELECT 
                ls.id_qr, (
				select date_scanner from logs_scanner l1 where l1.id_qr=ls.id_qr 
                and DATE(date_scanner)='$fecha'  order by date_scanner asc limit 1
                )  as first_scan_time,
                
                 (
				select type from logs_scanner l1 where l1.id_qr=ls.id_qr 
                and DATE(date_scanner)='$fecha'  order by date_scanner asc limit 1
                )  as first_type,
                
                (
				select date_scanner from logs_scanner l1 where l1.id_qr=ls.id_qr 
                and DATE(date_scanner)='$fecha'  order by date_scanner desc limit 1
                )  as last_scan_time,
                
                 (
				select type from logs_scanner l1 where l1.id_qr=ls.id_qr 
                and DATE(date_scanner)='$fecha'  order by date_scanner desc limit 1 
                )  as last_type,

                 u.tipo_usuario, u.id_usuario, u.nombre,
        apellido_pat, u.apellido_mat, u.matricula, u.programa, u.aquien_v,  
        u.motivo, u.area, u.tipo_usuario, tipo.nombre as tipo_user

        from logs_scanner ls   
        inner join cat_qr cat on
        cat.id_qr=ls.id_qr
        inner join usuarios u
        on u.id_usuario=cat.id_usuario
        inner join tipos_usuario tipo
        on tipo.idtipo_usuario=u.tipo_usuario
        WHERE
        DATE(date_scanner)='$fecha'
         group by ls.id_qr";
        $query =   $this->db->query($sql);

    return $query->getResult();
    }



}
<?php
namespace App\Controllers;
use App\Models\UserModel;

class Alta extends BaseController
{
    public $session=null;
    public $db;
    public $model;
    public $id_user_sesion;

    public function __construct(){

        if (!session()->has('id_operador')) {
            header('Location: ./');
            exit;
        }
        $this->db = db_connect(); 
        $this->model = new UserModel();
        $this->id_user_sesion=session()->get('id_operador');
    }
    public function index()
    {        

                return view('Alta_view', ['menu' => view('menu_view')]);
    }
    public function dataByTipo($tipo){
        $data=[];
        if($tipo==1){

            $tipo_usuario=$this->request->getPost('tipo_usuario');
            $nombre=$this->request->getPost('nombre');
            $ape_pat=$this->request->getPost('ape_pat');
            $ape_mat=$this->request->getPost('ape_mat');
            $matricula=$this->request->getPost('matricula');
            $programa=$this->request->getPost('programa');
            $data=[
                 'nombre'=>$nombre,
                 'apellido_pat'=>$ape_pat,
                 'apellido_mat'=>$ape_mat,
                 'matricula'=>$matricula,
                 'programa'=>$programa,
                 'tipo_usuario'=>$tipo_usuario,
                 'created_by'=>$this->id_user_sesion,
            ];
        }else if($tipo==2){
            $tipo_usuario=$this->request->getPost('tipo_usuario');
            $nombre=$this->request->getPost('nombre');
            $ape_pat=$this->request->getPost('ape_pat');
            $ape_mat=$this->request->getPost('ape_mat');

            $identificador=$this->request->getPost('identificador');
            $avisita=$this->request->getPost('avisita');
            $donde=$this->request->getPost('donde');
            $motivo=$this->request->getPost('motivo');
            $data=[
                'nombre'=>$nombre,
                'apellido_pat'=>$ape_pat,
                'apellido_mat'=>$ape_mat,
                'tipo_usuario'=>$tipo_usuario,
                'identificador'=>$identificador,
                'aquien_v'=>$avisita,
                'proviene_de'=>$donde,
                'motivo'=>$motivo,
                'created_by'=>$this->id_user_sesion,
           ];
        }else if($tipo==3){
            $tipo_usuario=$this->request->getPost('tipo_usuario');
            $nombre=$this->request->getPost('nombre');
            $ape_pat=$this->request->getPost('ape_pat');
            $ape_mat=$this->request->getPost('ape_mat');
            $no_empleado=$this->request->getPost('no_empleado');
            $area=$this->request->getPost('area');
            $data=[
                'nombre'=>$nombre,
                'apellido_pat'=>$ape_pat,
                'apellido_mat'=>$ape_mat,
                'n_empleado'=>$no_empleado,
                'area'=>$area,
                'tipo_usuario'=>$tipo_usuario,
                'created_by'=>$this->id_user_sesion,
           ];
        }
        return $data;

    }
    
    public function create(){
        $data=self::dataByTipo($this->request->getPost('tipo_usuario'));
        $insert=$this->model->create($data);

        $data['id_usuario']=$insert;

        $response=['status'=>'success',
              'data'=>$data,
            'msj'=>'Creado exitosamente'];
        echo json_encode($response);
    

    }
    public function read(){
        $tipo=$this->request->getGet('tipo');
        $data=$this->model->read($tipo);
        $response=['status'=>'success',
                  'data'=>$data,
                'msj'=>''];
                
        echo json_encode($response);
        die();
    

    }

 
}

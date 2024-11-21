<?php
namespace App\Controllers;
//use App\Models\ClistaModel;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QRCodeException;
use App\Libraries\Encript;
use App\Models\Catqr_model;
use App\Models\UserModel;
use App\Models\LogModel;






class Qr extends BaseController
{
    public $session=null;
    public $db;
    public $model;
    public $modelUser;
    public $modellog;

    public function __construct(){

        $this->session= \Config\Services::session();
        $this->db = db_connect(); 
        $this->model = new Catqr_model();
        $this->modelUser = new UserModel();
        $this->modellog = new LogModel();



    }
    public function index()
    {        
                return view('Qr_view');
    }


    public function recupera(){
        $verify=$this->verify_exist();

        if(isset($verify[0])){
            $response=['status'=>'success',
            'data'=>$verify[0],
            'msj'=>'El usuario cuenta con un qr'];

        }else{
            $response=['status'=>false,
            'data'=>'',
            'msj'=>'El usuario no cuenta con un qr'];
        }
        echo json_encode($response);
        die();


    }
    public function verify_exist($id_usuario=false){
        $id_usuario=($id_usuario ? $id_usuario :$this->request->getPost('id_usuario'));
        $exist=$this->model->get_active($id_usuario);

        return $exist;
    }
    public function desactivar(){
        $id_usuario=$this->request->getPost('id_usuario');
        $upd=$this->model->desactivar($id_usuario);
        $response=['status'=>'success',
        'data'=>$upd,
        'msj'=>'El QR se desactivo'];
        echo json_encode($response);
        die();

    }
    public function registraLog($idqr=false, $type=false){

        $res=false;
        if($idqr){
            $data=[
             'id_qr'=>$idqr,
              'type'=>$type];
            $this->modellog->create($data);
            $res=true;   
        }
        return $res;

    }


    public function scanner(){	
        if($this->request->getPost('code') && strlen($this->request->getPost('code') )){
            $code=$this->request->getPost('code');
            $long_code=strlen($code);
            require 'vendor/autoload.php';
            $encript = new Encript();
            $response=['status' =>false,
            'data' =>'',
            'msg' =>'Error x001',
            'extras' =>'Se recibio el codigo de acceso pero no se ejecuto ninguna funcio /Solo entro a la funcion'];

            if($long_code>10){
                $data_code=$this->model->get_code($code);
                $response=['status' =>false,
                'data' =>'',
                'msg' =>'Error x002',
                'extras' =>'longitud correcta del qr pero no encontro datos del qr'. json_encode($data_code)];
                
                if(isset($data_code[0])){
                    if($data_code[0]->type=='' or $data_code[0]->type=='SALIDA' ) {
                        $response=['status' =>false,
                        'data' =>'',
                        'msg' =>'Error x003',
                        'extras' =>'registrara entrada pero no valido las fechas'. json_encode($data_code)];
                        //aplicar reglar para dejar entrar
                        if( $data_code[0]->hour_entry!= '' && $data_code[0]->hour_entry!=NULL){
                            echo 'validar entrada x hora';
                        }elseif($data_code[0]->date_entry!= '' && $data_code[0]->date_entry!=NULL ){

                                $fecha_entry_bd = new DateTime($data_code[0]->date_entry);
                                $fecha_actual = new DateTime(date("Y-m-d") );

                                // Comparar solo las fechas, sin importar las horas
                                if ($fecha_entry_bd->format('Y-m-d') >= $fecha_actual->format('Y-m-d') ){
                                    //ya puede pasar 
                                    //pero validar si hay fecha de salida 
                                    if($data_code[0]->date_exit!= '' && $data_code[0]->date_exit!=NULL){
                                        $fecha_exit_bd = new DateTime($data_code[0]->date_exit);
                                        if($fecha_actual<= $fecha_exit_bd->format('Y-m-d') ){
                                            //pasa
                                            $insert=$this->registraLog($data_code[0]->id_qr, 'ENTRADA');
                                            $response=['status' =>'success',
                                            'data' =>$data_code[0],
                                            'msg' =>'Se registro su entrada correctamente',
                                            'extras' =>$insert . ' Su entrada esta dentro de la fecha de salida correcta' ];
                                        }else{
                                            $response=['status' =>false,
                                            'data' =>$data_code[0],
                                            'msg' =>'Acceso denegado: horario no permitido.',
                                            'extras' =>' Su entrada esta dentro de la fecha de salida correcta' ];
                                        }
                                    }else{
                                        //pasa
                                        $insert=$this->registraLog($data_code[0]->id_qr, 'ENTRADA');
                                        $response=['status' =>'success',
                                        'data' =>$data_code[0],
                                        'msg' =>'Se registro su entrada correctamente',
                                        'extras' =>$insert. 'no tiene fechas de salida'];
                                    }
                                }else{
                                    //no pasa por fechas
                                    $response=['status' =>false,
                                    'data' =>$data_code[0],
                                    'msg' =>'Acceso denegado: su fecha de ingreso ha caducado',
                                    'extras' => 'Su qr tiene fechas de ingreso que ya no son validas'];
                                }
                        }else{
                            $insert=$this->registraLog($data_code[0]->id_qr, 'ENTRADA');
                            $response=['status' =>'success',
                                       'data' =>$data_code[0],
                                       'msg' =>'Se registro su entrada correctamente',
                                       'extras' =>$insert];
                        }
                    }else{
                        $insert=$this->registraLog($data_code[0]->id_qr, 'SALIDA');
                        $response=['status' =>'success',
                        'data' =>$data_code[0],
                        'msg' =>'Nos vemos pronto.',
                        'extras' =>$insert];

                    }
                }else{
                    $response=['status' =>false,
                    'data' =>$data_code,
                    'msg' =>'Codigo QR no valido'];
                }
            }else{
                $accesobyidentificador=$this->modelUser->readByIdentificador($code);
                if(isset($accesobyidentificador[0])){
                        $insert=$this->registraLog($accesobyidentificador[0]->id_qr,($accesobyidentificador[0]->type=='' or $accesobyidentificador[0]->type=='SALIDA'  ? 'ENTRADA': 'SALIDA'));
                        $response=['status' =>'success',
                        'data' =>$accesobyidentificador,
                        'msg' =>'Bienvenido'];
                   
                }else{
                    $response=['status' =>false,
                    'data' =>$accesobyidentificador,
                    'msg' =>'Codigo  no valido'];
                }
            }

        }

        echo json_encode($response);
    
    }

    public function createAll(){
        $arr_id_usuario[]=$this->request->getPost('selectedItems');
        $response=['status'=>'false',
        'data'=>'',
        'msj'=>'no process'];
        for ($i=0; $i <count($arr_id_usuario[0]); $i++) { 
            $res[]=$this->processCreate($arr_id_usuario[0][$i]);
        }
        $response=['status'=>'success',
        'data'=>$res,
        'msj'=>'process'];
        echo    json_encode($response);
        die();

    }

    public function processCreate($id_usuario){

        $verify=$this->verify_exist($id_usuario);
        if(isset($verify[0])){
            $response=['status'=>'success',
            'data'=>$verify[0],
            'msj'=>'El usuario cuenta con un qr'];

        }else{

            require 'vendor/autoload.php';
            $encript = new Encript();
        
            $code=$encript->encode($id_usuario);
            $response=['status'=>false,
                        'data'=>'',
                        'msj'=>'No realizo ninguna accion'];
        

                    try {

                        $qrcode = new QRCode();
                        // Genera el código QR
                        $image = $qrcode->render($code);
                        if($this->request->getPost('date_entry') ==''){
                            $data=[
                                "code"=> $code ,
                                "id_usuario"=>$id_usuario ,
                                "img"=>$image ,
                                "activo"=>'1' ,
                                "created_at"=> date("Y-m-d H:i:s") 
                            ];
                        }else{
                            $data=[
                                "code"=> $code ,
                                "id_usuario"=>$id_usuario ,
                                "img"=>$image ,
                                "activo"=>'1' ,
                                'date_entry' => $this->request->getPost('date_entry') ,
                                'hour_entry' => $this->request->getPost('hour_entry') ,
                                'date_exit' => $this->request->getPost('date_exit') ,
                                'hour_exit' => $this->request->getPost('hour_exit') ,
                                "created_at"=> date("Y-m-d H:i:s") 

                            ];
                        }
                        $this->model->create($data);
                        $response=['status'=>'success',
                                    'data'=> $data ,
                                    'msj'=>'QR generado con exito'];
                    // echo '<img src="'.(new QRCode)->render($code).'" width="20%" alt="QR Code" />';

                    } catch (QRCodeException $e) {
                        return 'Error al generar el código QR: ' . $e->getMessage();
                        $response=['status'=>false,
                        'data'=> $e->getMessage() ,
                        'msj'=>'Fallo al crear el QR'];
                    }
        }
        return $response;

    }

    public function create(){
        $id_usuario=$this->request->getPost('id_usuario');
        $response=$this->processCreate($id_usuario);
        echo json_encode($response);
        die();
                
    }
 
}

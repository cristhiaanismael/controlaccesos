<?php
namespace App\Controllers;
//use App\Models\ClistaModel;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QRCodeException;
use App\Libraries\Encript;
use App\Models\Catqr_model;





class Qr extends BaseController
{
    public $session=null;
    public $db;
    public $model;

    public function __construct(){

        $this->session= \Config\Services::session();
        $this->db = db_connect(); 
        $this->model = new Catqr_model();

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
        $where=[
            'id_usuario' => $id_usuario,
            'activo' => 1        ];
        $exist=$this->model->get_active($where);

        return $exist;
    }

    public function create(){
        $id_usuario=$this->request->getPost('id_usuario');

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
                echo json_encode($response);
                die();
                
    }
 
}

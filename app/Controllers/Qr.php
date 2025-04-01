<?php
namespace App\Controllers;
//use App\Models\ClistaModel;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Output\QRGdImagePNG;
use chillerlan\QRCode\QRCodeException;
use App\Libraries\Encript;
use App\Models\Catqr_model;
use App\Models\UserModel;
use App\Models\LogModel;
use ZipArchive; // Importar ZipArchive







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

       /* if (!session()->has('id_operador')) {
            header('Location: ./');
            exit;
        }*/



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

    static function convierteEntradaBySalida($fecha_last_scan, $tipo_last_scan){
        $dia_last_registro = date('d', strtotime($fecha_last_scan));
        $res=false;
        if( $tipo_last_scan=='ENTRADA' && $dia_last_registro!=date('d') ){
            $res= true;
        }   
        return $res;

    }

    public function scanner(){	
        if($this->request->getPost('code') && strlen($this->request->getPost('code') )){
            $code=$this->request->getPost('code');
            $code=str_replace('-','/', $code);
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

                //MANEJO DE RETARDOS ENTRE DOS LECTURAS IGUALES
                if(isset($data_code[0])){
                    if (!empty($data_code[0]->date_scanner)) {
                        $dateFromDatabase = new \DateTime($data_code[0]->date_scanner);
                        $currentDate = new \DateTime("now");
                        $interval = $currentDate->getTimestamp() - $dateFromDatabase->getTimestamp();
                        if ($interval < 15) {
                            if($data_code[0]->type=="ENTRADA"){
                                $response=['status' =>'success',
                                'data' =>$data_code[0],
                                'msg' =>'Ya se ha registrado tu ENTRADA',
                                'extras' => 'entrada_ya_registrada' ];
                            }

                            else if($data_code[0]->type=="SALIDA"){
                                $response=['status' =>'success',
                                'data' =>$data_code[0],
                                'msg' =>'Ya se ha registrado tu SALIDA',
                                'extras' => 'salida_ya_registrada' ];
                            }
                            echo json_encode($response);
                            die();
                        }
                    }


                    if($data_code[0]->date_scanner!=null && $data_code[0]->date_scanner!=''){
                         $data_code[0]->type=( QR::convierteEntradaBySalida($data_code[0]->date_scanner, $data_code[0]->type) ? 'SALIDA' : $data_code[0]->type);
                    }

                    if($data_code[0]->type=='' or $data_code[0]->type=='SALIDA'  ) {
                        $response=['status' =>false,
                        'data' =>'',
                        'msg' =>'Error x003',
                        'extras' =>'registrara entrada pero no valido las fechas'. json_encode($data_code)];
                        //aplicar reglar para dejar entrar
                        if( $data_code[0]->hour_entry!= '' && $data_code[0]->hour_entry!=NULL){
                            //echo 'validar entrada x hora';
                            
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
                                            'data' =>$data_code=$this->model->get_code($code)[0],
                                            'msg' =>'Se registro su entrada correctamente',
                                            'extras' =>$insert . ' Su entrada esta dentro de la fecha de salida correcta' ];
                                        }else{
                                            $response=['status' =>false,
                                            'data' =>$data_code=$this->model->get_code($code)[0],
                                            'msg' =>'Acceso denegado: horario no permitido.',
                                            'extras' =>' Su entrada esta dentro de la fecha de salida correcta' ];
                                        }
                                    }else{
                                        //pasa
                                        $insert=$this->registraLog($data_code[0]->id_qr, 'ENTRADA');
                                        $response=['status' =>'success',
                                        'data' =>$data_code=$this->model->get_code($code)[0],
                                        'msg' =>'Se registro su entrada correctamente',
                                        'extras' =>$insert. 'no tiene fechas de salida'];
                                    }
                                }else{
                                    //no pasa por fechas
                                    $response=['status' =>false,
                                    'data' =>$data_code=$this->model->get_code($code)[0],
                                    'msg' =>'Acceso denegado: su fecha de ingreso ha caducado',
                                    'extras' => 'Su qr tiene fechas de ingreso que ya no son validas'];
                                }
                        }else{
                            $insert=$this->registraLog($data_code[0]->id_qr, 'ENTRADA');
                            $response=['status' =>'success',
                                       'data' =>$data_code=$this->model->get_code($code)[0],
                                       'msg' =>'Se registro su entrada correctamente',
                                       'extras' =>$insert];
                        }
                    }else{
                        //validar que la entrada que se tiene es del mismo dia
                        $insert=$this->registraLog($data_code[0]->id_qr, 'SALIDA');
                        $response=['status' =>'success',
                        'data' =>$data_code=$this->model->get_code($code)[0],
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

                    $tipoderegistro=null;
                    #SI LA FECHA DE ESCANER ES DIFERENTE DE  VACIA
                    if($accesobyidentificador[0]->date_scanner!=null && $accesobyidentificador[0]->date_scanner!=''){
                        #ENGARA EL FLUJO ACTUAL Y LO CONVERIRA EN ENTRADA PARA QUE EL PRIMER REGISTRO DEL DIA
                        # QUEDE COMO ENTRADA
                        $accesobyidentificador[0]->type=( QR::convierteEntradaBySalida($accesobyidentificador[0]->date_scanner, $accesobyidentificador[0]->type) ? 'SALIDA' : $accesobyidentificador[0]->type);
                    }
                    #DETECTA SI EL ULTIMO REGISTRO ES SALIDA O NO HAY UN REGISTRO PREVIO PARA QUE EL FLUJO SEA EL DE SALIDA
                    if($accesobyidentificador[0]->type=='' or $accesobyidentificador[0]->type=='SALIDA'){
                        $tipoderegistro='ENTRADA';
                    }else{
                        $tipoderegistro='SALIDA';
                    }
                    $insert=$this->registraLog($accesobyidentificador[0]->id_qr,$tipoderegistro);
                    $response=['status' =>'success',
                        'data' =>$accesobyidentificador[0],
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

    public function borrarCarpeta($carpeta='./public/temp/qrs_') {
        if (is_dir($carpeta)) {
            $archivos = array_diff(scandir($carpeta), array('.', '..'));
            foreach ($archivos as $archivo) {
                $ruta = $carpeta . DIRECTORY_SEPARATOR . $archivo;
                if (is_dir($ruta)) {
                    $this->borrarCarpeta($ruta); // Llamada recursiva
                } else {
                    unlink($ruta); // Elimina el archivo
                }
            }
            rmdir($carpeta);
        } else {
        }
    }
    public function borra_zip($archivo_zip=''){
        if(file_exists($archivo_zip)){
            if (unlink($archivo_zip)) {
                $this->borra_zip($archivo_zip);
               return true;
            } else {
                return false;
            }
        }else{
            return true;
        }
    }

    public function  addFolderToZip($folderPath, $zipArchive, $zipFolderPath = '') {
        $folder = opendir('./public/temp/qrs_/');
        while ($file = readdir($folder)) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            $filePath = $folderPath . DIRECTORY_SEPARATOR . $file;
            $zipPath = $zipFolderPath . DIRECTORY_SEPARATOR . $file;
            if (is_dir($filePath)) {
                $zipArchive->addEmptyDir($zipPath);
                addFolderToZip($filePath, $zipArchive, $zipPath); // Recursión
            } else {
                $zipArchive->addFile($filePath, $zipPath);
            }
        }
        closedir($folder);
    }

    public function create_imgs($array){
        $data=$this->model->getById($array);
        $this->borrarCarpeta();
        $this->borra_zip('./public/temp/qrs_zip.zip');
        mkdir('./public/temp/qrs_', 0777, true);
        $res=[];
     
        if(isset($data[0])){
            for($i=0;$i<count($data);$i++){
                $file_path = './public/temp/qrs_/'.$data[$i]->nombre."_".$data[$i]->apellido_pat."_".$data[$i]->apellido_mat.'.png';
                if (strpos($data[$i]->img, 'data:image/png;base64,') === 0) {
                    $base64_string = substr($data[$i]->img, strlen('data:image/png;base64,'));
                }
                $image_data = base64_decode($base64_string);
                if(file_put_contents($file_path, $image_data )) {
                    $res['msj']=[$data[$i]->id_usuario => 'creada correctamente'];

                } else {
                    $res['msj']=[$data[$i]->id_usuario => 'problema'];
                }

            }
        }
        return $res;

    }

    public function createZip(){
        $folderToCompress = './public/temp/qrs_';
        $zipFileName = './public/temp/qrs_zip.zip';
        $zip = new ZipArchive();
        if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {
            $this->addFolderToZip($folderToCompress, $zip);
            $zip->close();
            
            return 'Carpeta comprimida con éxito en ' . $zipFileName;
        } else {
            return 'No se pudo crear el archivo ZIP.';
        }

    }

    public function createAll(){
        $arr_id_usuario[]=$this->request->getPost('selectedItems');
        $response=['status'=>'false',
        'data'=>'',
        'msj'=>'no process'];
        for ($i=0; $i <count($arr_id_usuario[0]); $i++) { 
            $res[]=$this->processCreate($arr_id_usuario[0][$i]);

        }
        $res['imgs']=$this->create_imgs($arr_id_usuario[0]);
        $res['zip']=$this->createZip();
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
        
            //$code=$encript->encode($id_usuario);

            $code=base64_encode($id_usuario) .'/'.strtotime("now"). rand(100, 999);

            $response=['status'=>false,
                        'data'=>'',
                        'msj'=>'No realizo ninguna accion'];
        

                    try {

                        $options = new QROptions;
                        $options->version             = 2;
                        $options->outputInterface     = QRGdImagePNG::class;
                        $options->scale               = 20;
                        $options->outputBase64        = false;
                        $options->bgColor             = [200, 150, 200];
                        $options->imageTransparent    = true;
                        #$options->transparencyColor   = [233, 233, 233];
                        $options->drawCircularModules = false;
                        $options->drawLightModules    = true;
                        $options->drawSquareModules   = true; 
                        $options->circleRadius        = 0.4;
                        

                        $qrcode = new QRCode($options);
                        $image = $qrcode->render($code);
                        $imageResource = imagecreatefromstring($image);
                        $textColor = imagecolorallocate($imageResource, 0, 0, 0); // Blanco
                        $fontPath = './public/resources/Parkinsans/Parkinsans-VariableFont_wght.ttf';  // Cambia esto a la ubicación de tu archivo de fuente
                        $fontSize = 30;  // Tamaño de la fuente
                        $userdata=$this->modelUser->readById($id_usuario);

                        $nombreuser=(isset($userdata[0]) ? $userdata[0]->nombre. ' '. $userdata[0]->apellido_pat. ' '. $userdata[0]->apellido_mat  : 'S/N');

                        $text = $nombreuser;
                        $textX = 60;
                        $textY = imagesy($imageResource) - 20;
                        imagettftext($imageResource, $fontSize, 0, $textX, $textY, $textColor, $fontPath, $text);
                        ob_start();
                        imagepng($imageResource);
                        $imageWithText = ob_get_clean();
                        imagedestroy($imageResource);
                        $imageBase64 = base64_encode($imageWithText);
                        $image = 'data:image/png;base64,' . $imageBase64;



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
    public function gafete(){
        // session()->get('id_operador');
        // $menu = view('Menu_view'); 
        $id_usuario=$this->request->getGet('id');

        $userdata=$this->modelUser->readById($id_usuario);

        $datos=[];
        if(isset($userdata[0])){
            $data=$this->model->getById([$id_usuario]);
            if(isset($data[0])){

                $datos['nombre']=$userdata[0]->nombre.' '. $userdata[0]->apellido_pat.' '.$userdata[0]->apellido_mat;
                $datos['numero']=$userdata[0]->n_empleado;
                $datos['area']=$userdata[0]->area;
                $datos['puesto']=$userdata[0]->puesto;
                $datos['foto']=( $userdata[0]->img ==''  ? 'default.jpg' : $userdata[0]->img);
                $datos['qr']=$data[0]->img;
                $datos['tipo']=$data[0]->tipo_usuario;

                $datos['identificador']=$data[0]->identificador;
                $datos['aquien_v']=$data[0]->aquien_v;
                $datos['proviene_de']=$data[0]->proviene_de;
                $datos['motivo']=$data[0]->motivo;


            }



        }
         return view('Gafete_view', ['datos' =>$datos,
                                                 'nivel'=>session()->get('nivel')]
                             );
         }


         public function gafetes(){
            $ids = json_decode($_GET['ids']);


            $userdata=$this->modelUser->readByIdIn($ids);
            $datos = []; // Inicializar el array para almacenar los datos de todos los usuarios

            // Recorrer el array de usuarios
            foreach ($userdata as $user) {
                $info = []; // Array temporal para cada usuario
            
                $data=$this->model->getById([$user->id_usuario]);

                $info['nombre'] = $user->nombre . ' ' . $user->apellido_pat . ' ' . $user->apellido_mat;
                $info['numero'] = $user->n_empleado;
                $info['area'] = $user->area;
                $info['puesto'] = $user->puesto;
                $info['foto'] = ($data[0]->foto == '' ? 'default.jpg' : $data[0]->foto);

                $info['qr'] = $user->img;
                $info['tipo'] = $user->tipo_usuario;
                $info['identificador'] = $user->identificador;
                $info['aquien_v'] = $user->aquien_v;
                $info['proviene_de'] = $user->proviene_de;
                $info['motivo'] = $user->motivo;
                $info['programa'] = $data[0]->programa ;

                $datos[] = $info;
            }
             return view('Gafetes_view', ['datos' =>$datos,
                                                     'nivel'=>session()->get('nivel')]
                                 );
             }
 
 
}

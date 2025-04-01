<?php
namespace App\Controllers;
use App\Models\ImagenperfilModel;

class Imagen extends BaseController{
    public $model;
    public function __construct(){
        $this->model = new ImagenperfilModel();
    }

    public function codifica(){
         $archivo_png = './imagen.jpg';
         if (file_exists($archivo_png)) {
             $imagen = file_get_contents($archivo_png);
             $imagen_base64 = base64_encode($imagen);
             return $imagen_base64;
         } else {
             return false;
         }
    }

    public function index(){
        $texto=$this->codifica();
        if(!$texto){
            echo 'error';
            die();
        }
        $values=[
            'imagen_base64'=>$texto,
            'id_usuario'=>rand(0,10),
            'activo'=>1
        ];
        $this->model->create($values);

        //borrar el archivo
        unlink('./imagen.jpg');







        $archivo = 'imagen_'.date('Y-m-d-H-i-s'). '.png';
        $ruta="./public/archivos";
        if (is_dir($ruta)) {
            $archivos = scandir($ruta);
            foreach ($archivos as $arc ) {
                if($arc!='.' && $arc!='..'){
                    unlink($ruta.'/'.$arc);
                }
            }
        } else {
            mkdir($ruta, 0777, true);
        }
        $rutacompleta=$ruta.'/'.$archivo;
        $archivoAbierto = fopen($rutacompleta, 'w');
        if($archivoAbierto){
            fwrite( $archivoAbierto, base64_decode($texto));
            //ojo
            header('location:'.$rutacompleta);
        }else{
            echo 'Error en el archivo';
        }
    }
}
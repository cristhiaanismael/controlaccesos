<?php
namespace App\Controllers;
//use App\Models\ClistaModel;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QRCodeException;



class Qr extends BaseController
{
    public $session=null;
    public $db;
    public function __construct(){

        $this->session= \Config\Services::session();
        $this->db = db_connect(); 
    }
    public function index()
    {        
                return view('Qr_view');
    }

    public function create(){
        require 'vendor/autoload.php';
        $data = 'id_usuario=1023&acceso=25';
            // Genera un vector de inicialización (IV)
  /*  $ivLength = openssl_cipher_iv_length('AES-256-CBC');
    $iv = openssl_random_pseudo_bytes($ivLength);
    
    // Encripta el texto
    $ciphertext = openssl_encrypt($plaintext, 'AES-256-CBC', $key, 0, $iv);

       // Decodifica el texto encriptado
       $ciphertext = base64_decode($ciphertext);
    
       // Extrae el IV y el ciphertext
       $ivLength = openssl_cipher_iv_length('AES-256-CBC');
       $iv = substr($ciphertext, 0, $ivLength);
       $ciphertext = substr($ciphertext, $ivLength);
       
       // Desencripta el texto
       return openssl_decrypt($ciphertext, 'AES-256-CBC', $key, 0, $iv);
    */
    // Combina el IV y el ciphertext para poder desencriptarlo luego
    return base64_encode($iv . $ciphertext);
        try {
            $qrcode = new QRCode();
            // Genera el código QR
            $image = $qrcode->render($data);
            
            // Establece el tipo de contenido para la imagen
         //   var_dump( );

         echo '<img src="'.(new QRCode)->render($data).'" width="20%" alt="QR Code" />';

        } catch (QRCodeException $e) {
            return 'Error al generar el código QR: ' . $e->getMessage();
        }
        
    }
 
}

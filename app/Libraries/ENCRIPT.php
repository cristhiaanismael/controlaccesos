<?php
namespace App\Libraries;
class Encript
{
      
	public static function decode($ciphertext, $key)
	{

            // Decodifica el texto encriptado
        $ciphertext = base64_decode($ciphertext);
        
        // Extrae el IV y el ciphertext
        $ivLength = openssl_cipher_iv_length('AES-256-CBC');
        $iv = substr($ciphertext, 0, $ivLength);
        $ciphertext = substr($ciphertext, $ivLength);
        
        // Desencripta el texto
        return openssl_decrypt($ciphertext, 'AES-256-CBC', $key, 0, $iv);
	}

	public  function  encode($plaintext)
	{
                $key=$_ENV['SECRET_KEY'];
                // Genera un vector de inicialización (IV)
                $ivLength = openssl_cipher_iv_length('AES-256-CBC');
                $iv = openssl_random_pseudo_bytes($ivLength);
                
                // Encripta el texto
                $ciphertext = openssl_encrypt($plaintext, 'AES-256-CBC', $key, 0, $iv);
                
                // Combina el IV y el ciphertext para poder desencriptarlo luego
                return base64_encode($iv . $ciphertext);        
	}


}

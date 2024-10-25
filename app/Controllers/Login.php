<?php

namespace App\Controllers;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

use CodeIgniter\HTTP\IncomingRequest;
use App\Models\SUserModel;
//use App\Models\LoggerAuthModel;
//use App\Libraries\JWT;
class Login extends BaseController
{
    public $session=null;
    public $Logger;
    public function __construct(){
        $this->session= \Config\Services::session();
        //$this->Logger = new LoggerAuthModel();
        helper('logger');
    }

    public function ProccesAuto(){
        $res=json_decode(self::AutoLogin());
        if($res->operation=='sucess'){
            return redirect()->to(base_url().'/ExcelLector'); 
        }else{
            
           // return redirect()->to(env('LINK_SOI_RAIZ').'/login'); 
        }
    }

    public function AutoLogin()
    {
        if(isset($_REQUEST['token'])  ){
            $request = service('request');
            require APPPATH . "/Libraries/JWT.php";
            $jwt=$request->getPost('token');

            try {
                $decoded =  JWT::decode($jwt, new Key(env('JWT_SECRET'), 'HS256'));
                $UserModel = new SUserModel();
                $id_decodeUser=$decoded->id_user;
               // $id_decodeUser=1;
                $query=$UserModel->where('id_user', $id_decodeUser)->get();


                if(count($query->getResult())>0){
                    $id_user=$query->getResult()[0]->id_user;
                    $id_sede=$query->getResult()[0]->id_sede;
                    $nombre=$query->getResult()[0]->name. ' '. $query->getResult()[0]->last_name; 

                    $arr=['id_user'=>$id_user,
                          'id_sede'=>$id_sede,
                          'nombrecompleto'=>$nombre];
                    self::CreateSesions($arr );
                    if($this->session->get('id_user')>0){
                        $data=['operation'=>'sucess'];
                        logger($jwt, $id_decodeUser, json_encode($data), 'sucess', 'login');

                    }else{
                        $data=['operation'=>'fail',
                        'msj'=>'Sesion not created'];
                         logger($jwt, $id_decodeUser, json_encode($data), 'error','login');
                    }   
                }else{
                    $data=['operation'=>'fail',
                        'msj'=>'users not exists'];
                         logger($jwt, $id_decodeUser, json_encode($data), 'error','login');
                }
            } catch (\Exception $e) {
                $data=['operation'=>'fail',
                        'msj'=>'error con el token',
                        'description'=>''.$e ];
                logger($jwt, null, json_encode($data), 'error', 'login');
                /**crear loguer n#semana guardar errores anio-semana */
            }
        }else{
            $data=['operation'=>'fail',
                   'msj'=>'No se recibio token'];
            logger(null, null, json_encode($data), 'error', 'login');
        }
        return json_encode($data);
        
    }
    public function CreateSesions($data){
        $this->session->set($data);
        return true;
    }
}

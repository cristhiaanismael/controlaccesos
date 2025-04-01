<?php

namespace App\Controllers;
use App\Models\UserModel;
use App\Models\LogModel;
use CodeIgniter\API\ResponseTrait;

class Admin extends BaseController
{
    use ResponseTrait;


    public function __construct(){
       
        if (!session()->has('id_operador')) {
            header('Location: ./');
            exit;
        }
        if(session()->get('nivel')>2){
            header('Location: ./alta');
            exit;
        }
    }

    public function index()
    {
        $menu = view('Menu_view'); 

       return view('Admin_view', ['menu' => $menu]);

    }
    public function aforo(){

        $logModel = new LogModel();
        $data = $logModel->usuariosDentro();
       

        $response=['status' =>true,
        'data' =>$data,
        'msg' =>''];
        return $this->respond($response, 200);

    }

    public function movimientos(){

        $logModel = new LogModel();
        $fecha = $this->request->getGet('fecha');
        $data = $logModel->movimientos($fecha);
        $response=['status' =>true,
        'data' =>$data,
        'msg' =>''];
        return $this->respond($response, 200);

    }

    public function resumen(){

        $logModel = new LogModel();
        $fecha = $this->request->getGet('fecha');
        $data = $logModel->resumen($fecha);
        $response=['status' =>true,
        'data' =>$data,
        'msg' =>''];
        return $this->respond($response, 200);

    }
   
}

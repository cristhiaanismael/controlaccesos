<?php
namespace App\Controllers;
use App\Models\UserModel;



class Prueba extends BaseController{


    public $model;
    public $cualquiernombre;

    public function __construct(){

        $this->model = new UserModel();

        
        $this->cualquiernombre = 'algo';
    }


    public function index(){
        $data=$this->model->read(3);
        var_dump($data);
        return view('Prueba_view');
    }

}
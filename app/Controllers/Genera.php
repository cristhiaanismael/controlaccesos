<?php
namespace App\Controllers;
//use App\Models\ClistaModel;

class Genera extends BaseController
{
    public $db;
    public function __construct(){
       
        if (!session()->has('id_operador')) {
            header('Location: ./');
            exit;
        }
        $this->db = db_connect(); 
    }
    public function index(){
   // session()->get('id_operador');
    $menu = view('Menu_view'); 
    return view('Genera_view', ['menu' => $menu,
                                            'nivel'=>session()->get('nivel')]
                        );
    }
}

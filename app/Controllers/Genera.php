<?php
namespace App\Controllers;
//use App\Models\ClistaModel;

class Genera extends BaseController
{
    public $session=null;
    public $db;
    public function __construct(){

        $this->session= \Config\Services::session();
        $this->db = db_connect(); 
    }
    public function index()
    {        
                return view('Genera_view');
    }
 
}

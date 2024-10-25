<?php
namespace App\Controllers;
//use App\Models\ClistaModel;

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
 
}

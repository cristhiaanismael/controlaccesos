<?php

namespace App\Models;

use CodeIgniter\Model;

class Operadores_Model extends Model
{
    protected $table = 'operadores'; 
    protected $primaryKey = 'id_operador';
    protected $allowedFields = ['username', 'password']; 
    
}
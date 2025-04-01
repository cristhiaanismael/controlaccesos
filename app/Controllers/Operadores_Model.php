<?php

namespace App\Models;

use CodeIgniter\Model;

class Operadores_Model extends Model
{
    protected $table = 'operadores';  // Nombre de la tabla en la base de datos
    protected $primaryKey = 'id_operador';
    protected $allowedFields = ['username', 'password']; // Campos que se pueden insertar y actualizar

    // Si quieres realizar la validación de la contraseña en base al hash, puedes agregar un método para eso
    // Por ejemplo, si usas bcrypt para hashear las contraseñas
}
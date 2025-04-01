<?php

namespace App\Controllers;

use App\Models\Operadores_Model;

class AuthController extends BaseController
{
    public function login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        if (empty($username) || empty($password)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Todos los campos son obligatorios.']);
        }
        $model = new Operadores_Model();
        $user = $model->where('username', $username)->first();
        if ($user) {
            session()->set('id_operador',  $user['id_operador']);
            session()->set('nivel',  $user['nivel']);
            if (trim(md5($password)) == trim($user['password'])) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Inicio de sesión exitoso']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Contraseña incorrecta.']);
            }
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Código QR no encontrado.']);
        }
    }
    public function logout()
    {
        // Destruir la sesión
        session()->destroy();

        // Redirigir al usuario a la página de inicio o login
        header('Location: ./');
        exit;
    }
}
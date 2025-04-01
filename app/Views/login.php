<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Control de Acceso icami</title>
    <link rel="icon" href="./public/resources/img/logo.ico" type="image/x-icon">


        <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- jQuery library -->

    <!-- Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Enlace a Bootstrap 4 -->
    <!-- Estilo personalizado (opcional) -->
    <style>
        .login-container {
            margin-top: 50px;
        }
        .qr-image {
            width: 160px;
            height: 109px;
        }
        .form-container {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <!-- Contenedor principal -->
    <div class="container login-container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- Formulario de login -->
                <div class="form-container">
                    <h3 class="text-center mb-4">Control de Acceso</h3>
                    <!-- Icono QR desde Google -->
                    <div class="text-center mb-4">
                        <img src="./public/resources/img/logo2.png"  alt="QR Code" class="qr-image">
                    </div>
                    <!-- Formulario -->
                    <form id='form_login'>
                        <div class="form-group">
                            <label for="username">Código de Acceso</label>
                            <input type="text" class="form-control" id="username" placeholder="Introduce tu código QR" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" class="form-control" id="password" placeholder="Contraseña" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
                    </form>
                    <div class="text-center mt-3">
                        <a href="#" onclick='alert("Comunicate con el administrador")'>¿Olvidaste tu contraseña?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
<script src='./public/resources/js/auth.js'></script>

</html>
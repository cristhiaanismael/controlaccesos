<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido Icami</title>
    <meta name="description" content="Control de accesos qr">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <script src="./public/resources/js/notify.min.js"></script>

    <!-- STYLES -->
     <style>
        .mayus{
            text-transform: uppercase;
        }

        .text {
  font-size:28px;
  font-family:helvetica;
  font-weight:bold;
  color:black;
  text-transform:uppercase;
}
.parpadea {
  
  animation-name: parpadeo;
  animation-duration: 1s;
  animation-timing-function: linear;
  animation-iteration-count: infinite;

  -webkit-animation-name:parpadeo;
  -webkit-animation-duration: 1s;
  -webkit-animation-timing-function: linear;
  -webkit-animation-iteration-count: infinite;
}

@-moz-keyframes parpadeo{  
  0% { opacity: 1.0; }
  50% { opacity: 0.0; }
  100% { opacity: 1.0; }
}

@-webkit-keyframes parpadeo {  
  0% { opacity: 1.0; }
  50% { opacity: 0.0; }
   100% { opacity: 1.0; }
}

@keyframes parpadeo {  
  0% { opacity: 1.0; }
   50% { opacity: 0.0; }
  100% { opacity: 1.0; }
}

.body {
  background: linear-gradient(90deg, #73ff5f, #ffffff, #73ff5f);
  animation: flash 2s infinite;
  height: 100vh; /* Asegura que ocupe toda la pantalla */
  margin: 0;
}

/* Animación de destello */
@keyframes flash {
  0%, 100% {
    background: #73ff5f; /* Fondo oscuro */
  }
  50% {
    background: #ffffff; /* Fondo blanco brillante */
  }
}



.body_error {
  background: linear-gradient(90deg, #ff0611, #ffffff, #ff0611);
  animation: flash_error 2s infinite;
  height: 100vh; /* Asegura que ocupe toda la pantalla */
  margin: 0;
}

/* Animación de destello */
@keyframes flash_error {
  0%, 100% {
    background: #ff0611; /* Fondo oscuro */
  }
  50% {
    background: #ffffff; /* Fondo blanco brillante */
  }
}


#typelog{
  font-size: 4vw;
}

.user-photo {
    width: 200px;
    height: 200px;
    object-fit: cover;
    border-radius: 50%; /* Hace que la imagen sea redonda */
    display: block;
    margin: 0 auto 10px auto;
  }

     </style>


</head>
<body class='' >

<div class="container">
  <div class="row justify-content-center align-items-center minh-100">
    <div class="col-lg-12">
      <div>
        <img class="img-fluid rounded mx-auto d-block" alt="logo" width="30%" src='./public/resources/img/LOGO-min.png'>
      </div>

      <!--<img src="" class="user-photo" style="display:none" id="profile" alt="Foto del participante">-->


      <div>
        <p style="font-size:24px;" class="text-center"><i class="fa fa-id-badge"> Control de accesos</i></p>
      </div>

    </div>

  </div>
</div>


<div style='display:none'>
    <audio id="audio_error">
        <source src="./public/resources/audio/error.mp3" type="audio/mp3">
        Tu navegador no soporta la etiqueta de audio.
    </audio>
    <audio id="audio_success">
        <source src="./public/resources/audio/login.mp3" type="audio/mp3">
        Tu navegador no soporta la etiqueta de audio.
    </audio>
    

    <audio id="audio_bienvenido">
        <source src="./public/resources/audio/voz/bienvenido.mp3" type="audio/mp3">
        bienvenido.
    </audio>
    <audio id="audio_hasta_pronto">
        <source src="./public/resources/audio/voz/hasta_pronto.mp3" type="audio/mp3">
        hasta_pronto.
    </audio>
    <audio id="audio_no_valido">
        <source src="./public/resources/audio/voz/no_valido.mp3" type="audio/mp3">
        no_valido.
    </audio>
    <audio id="audio_entrada_registrada">
        <source src="./public/resources/audio/voz/entrada_registrada.mp3" type="audio/mp3">
        entrada_registrada.
    </audio>
    <audio id="audio_salida_registrada">
        <source src="./public/resources/audio/voz/salida_registrada.mp3" type="audio/mp3">
        salida_registrada.
    </audio>
    
</div>




<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
        <form id='form_scanner' action='#' >
            <br>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <span class="input-group-text"><i class="fa fa-qrcode" style="font-size:2.1em"></i></span>
            </div>

            <input type="text" class="form-control form-control-lg" placeholder="Escane su QR"
             required='required' id='qr' name='qr' autocomplete="off">
        </div>

   
        </form>
        </div>
        <div class="col-md-3"></div>

    </div>
</div>

<div class="container">
    <div class="row">
    <div class='col-md-12 '>
    <img src="" class="user-photo" style="display:none" id="profile" alt="Foto del participante">

    </div>

      <div class='col-md-12 row'>

        <div class="col-md-4 md-3"></div>
        <div class="col-md-4 md-8"><h1 id='typelog'> </h1></div>
        <div class="col-md-4"></div>
      </div>

        <div class='col-md-4'></div>

        <div class='col-md-4' id='welcom_participante' style='display:none'>

            <h5 class='mayus'><i class="fa fa-mortar-board"></i><i id='name_participante'> </i></h5>
            <h5 class='mayus'><i class="fa fa-address-card-o"></i> <i id='programa'  > </i></h5>
        </div>
        <div class='col-md-4' id='welcom_empleado' style='display:none' >

            <h5 class='mayus'><i class="fa fa-black-tie"></i> <i id='name_empleado'></i> </h5>
            <h5 class='mayus'><i class="fa fa-building"></i>Area: <i class='mayus' id='depto'> </i></h5>
            <h5 class='mayus'><i class="fa fa-briefcase"></i>Puesto: <i class='mayus' id='puesto'></i> </h5>
        </div>
        <div class='col-md-4' id='welcom_visitante' style='display:none' >
            <h5 class='mayus' ><i class="fa fa-user-secret"></i><i id='name_visita'> </i> </h5>
            <h5><i class="fa fa-male"></i> Visita a: <i class='mayus' id='visita'></i></h5>
            <h5><i class="fa fa-question-circle"></i> Motivo: <i class='mayus' id='motivo'></i></h5>

        </div>
        <div class='col-md-4'></div>

        <div class='col-md-4'></div>
        <div class='col-md-4' id='hour' style='display:none'>
                            <h3  class="parpadea text"><i class="fa fa-clock-o"></i><i id='datescanner'></i> </h3>
        </div>
        <div class='col-md-4'></div>
        
    </div>
    
    
</div>
</body>
<script src='./public/resources/js/scaneo.js'></script>

<script>
    $(document).ready(()=>{
        $('#qr').focus();
    });
  



</script>


</html>

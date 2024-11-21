<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido Icami</title>
    <meta name="description" content="Control de accesos qr">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico">
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



     </style>


</head>
<body>

<div class="container">
  <div class="row justify-content-center align-items-center minh-100">
    <div class="col-lg-12">
      <div>
        <img class="img-fluid rounded mx-auto d-block" alt="logo" src='./public/resources/img/LOGO-min.png'>
      </div>

      <div>
        <br>
        <p style="font-size:24px;" class="text-center"><i class="fa fa-id-badge"> Control de accesos</i></p>
      </div>

    </div>

  </div>
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
            <input type="text" class="form-control form-control-lg" placeholder="Escane su QR" required='required' id='qr' name='qr'>
        </div>

   
        </form>
        </div>
        <div class="col-md-3"></div>

    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-5"></div>
        <div class="col-md-3"><h1 id='typelog'>Bienvenido </h1></div>
        <div class="col-md-3"></div>

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

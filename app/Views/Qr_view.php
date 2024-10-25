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
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- STYLES -->


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
        <form>
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
    <div class="col-md-3"><h1>Bienvenido </h1>
    </div>
    <div class="col-md-3"></div>


        <div class='col-md-4'></div>
        <div class='col-md-4'>
            <h5  style='display:none'><i class="fa fa-mortar-board"></i> Cristhian Ismael Ramirez Urbano </h5>
            <h5 style='display:none'><i class="fa fa-black-tie"></i> Armando Olvera </h5>
            <h5 style='display:'><i class="fa fa-user-secret"></i> Provedor walmart </h5>
        </div>
        <div class='col-md-4'></div>
        <div class='col-md-4'></div>
        <div class='col-md-4'>
            <h5  style='display'><i class="	fa fa-address-card-o"></i> Programa PSL-4 </h5>
        </div>

        <div class='col-md-4'></div>
        <div class='col-md-4'></div>
        <div class='col-md-4'>
            <h5  style='display'><i class="	fa fa-address-card-o"></i> 13:35 </h5>
        </div>
        
    </div>
    
    
</div>
</body>
<script>
    $(document).ready(()=>{
        $('#qr').focus();
    });
</script>

</html>

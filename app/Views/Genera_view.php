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
    <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- jQuery library -->

    <!-- Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>


    <!-- STYLES -->
     <style>

.form-control-feedback {
  position: absolute;
  padding: 10px;
  pointer-events: none;
}

.form-control {
  padding-left: 30px!important;
}
     </style>


</head>
<body>

<div class="container">
  <div class="row justify-content-center align-items-center minh-100">
    <div class="col-lg-12">
      <div>
        <img class="img-fluid rounded mx-auto d-block" alt="logo" width='25%' src='./public/resources/img/LOGO-min.png'>
      </div>

      <div>
        <br>
        <p style="font-size:24px;" class="text-center"><i class="	fa 	fa fa-qrcode"> Generacion de Accesos</i></p>
      </div>

    </div>

  </div>
</div>

<div class="container">

    <div class="row">
            <div class='col-md-4'></div>
            <div class='col-md-4'>
              <select name='tipo_usuario' required='required'  id='tipo_usuario' class='form-control'>
                <option value='0'>Selecciona una opcion</option>
                <option value='1'>Participante</option>
                <option value='2'>Visitante</option>
                <option value='3'>Empleado</option>
              </select>
            </div>
            <div class='col-md-4'></div>

                <div class='col-md-12  mt-3'>
                    <div class="row">

                        <table id="myTable" class="display">
                            <thead>
                                <tr>
                                    <th>Column 1</th>
                                    <th>Column 2</th>
                                    <th>Column 3</th>
                                    <th>Column 4</th>
                                    <th>Column 5</th>
                                </tr>
                            </thead>
                            <tbody id='tbody'>
                              
                            </tbody>
                        </table>

                    </div>
                </div>
              
    </div>

</div>


</body>
<script src='./public/resources/js/genera.js'></script>

<script>
    
</script>

</html>

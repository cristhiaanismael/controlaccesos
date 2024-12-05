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
    <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.dataTables.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- jQuery library -->

    <!-- Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap4.js"></script>

    <script src="https://cdn.datatables.net/responsive/3.0.3/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.3/js/responsive.dataTables.js"></script>
    <script src="./public/resources/js/notify.min.js"></script>



    <script src="https://cdn.datatables.net/buttons/3.2.0/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.print.min.js"></script>

    <style>
      
        .table-container {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<?=$menu?>

<div class="container">
            <div class="row justify-content-center align-items-center minh-100">
                <div class="col-lg-12">
                    <div>
                        <img class="img-fluid rounded mx-auto d-block" alt="logo" width='35%' src='./public/resources/img/LOGO-min.png'>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-12">
                    <h2 class="text-center">Panel de Administración - Control de Personal</h2>
                    <hr>
                </div>
            </div>
    
            <!-- Filtro por fecha-->
           
            <br>


            <div class="container mt-5">
                <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4"></div>

                    <div class="col-md-4">
                        <!-- Input Picker con botón "Go" al lado -->
                        <div class="input-group">
                            <!-- Input tipo picker (en este caso, un input de fecha) -->
                            <input type="date" class="form-control" id="picker" placeholder="Selecciona una fecha">
                            <!-- Botón "Go" -->
                            <div class="input-group-append">
                                <button class="btn btn-primary" id="goBtn">
                                    Go
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


    <br>
    <ul class="nav justify-content-center">
    <li class="nav-item bg-light" id='aforo'>
        <a class="nav-link active" onclick="Admin.active('aforo'); admin.consulta_aforo() " href="#">AFORO REALTIME</a>
    </li>
    <li class="nav-item" id='movimientos'>
        <a class="nav-link" href="#" onclick="Admin.active('movimientos'); admin.movimientos()" >REPORTE MOVIMIENTOS</a>
    </li>
    <li class="nav-item" id='resumido'>
        <a class="nav-link" href="#" onclick="Admin.active('resumido'); admin.resumen()" >REPORTE RESUMIDO</a>
    </li>
    </ul>

    <div>

        <div class="table-container contenedores" id='div_aforo'>
            <table class="table table-striped table-bordered" id='table_realtime'>
            </table>
        </div>

        <div class="table-container contenedores" id='div_movientos'>
            <div stylw='margin-right: 100px;'  ></div>
            <table class="table table-striped table-bordered" id='table_movimientos'>
            </table>
        </div>

        <div class="table-container contenedores" id='div_resumen'>
            <div class='row'>
                <div class='col-md-6 bg-success'><strong>Primer Registro del Día
                </strong></div>
                <div class='col-md-6 bg-info'><strong>Ultimo Registro del Día</strong></div>

            </div><br>
            <div stylw='margin-right: 100px;'  ></div>
            <table class="table table-striped table-bordered" id='table_resumen'>
            </table>
        </div>


    </div>
    <input type="hidden" id='option' value='aforo'>
  

 
    
    <!-- Tabla de empleados -->
   
</div>


<script src='./public/resources/js/admin.js'></script>

</body>
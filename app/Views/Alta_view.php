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
        <img class="img-fluid rounded mx-auto d-block" alt="logo" width='35%' src='./public/resources/img/LOGO-min.png'>
      </div>

      <div>
        <br>
        <p style="font-size:24px;" class="text-center"><i class="	fa fa-user-plus"> Alta de usuarios</i></p>
      </div>

    </div>

  </div>
</div>

<div class="container">
  <form id='form_alta' action='' method='POST'>

    <div class="row">
      <div class='col-md-4'></div>
          <div class='col-md-4'>
            <div class="alert alert-warning">
                <strong>Tipo de usuario</strong> 
            </div>
              <select name='tipo_usuario' required='required'  id='tipo_usuario' class='form-control'>
                <option value='1'>Participante</option>
                <option value='2'>Visitante</option>
                <option value='3'>Empleado</option>
              </select>
          </div>
          <div class='col-md-4'></div>

              <div class='col-md-12  mt-3'>
                <div class="row">

                      <div class='col-md-4'></div>
                      <div class='col-md-4'>
                        <div class="alert alert-success">
                            <strong>Datos del usuario</strong>
                        </div>
                      </div>
                      <div class='col-md-4'></div>
                 </div>
              </div>
              

          <div class='col-md-4'>

            <div class="form-group has-feedback">
              <i class="fa fa-user form-control-feedback"></i>
              <input type="text" class="form-control" required='required' id='nombre' name='nombre' placeholder='Nombre/Razon'>
            </div>
          </div>

          <div class='col-md-4'>
            <div class="form-group has-feedback">
              <i class="fa fa-user form-control-feedback"></i>
              <input type="text" class="form-control" id='ape_pat' name='ape_pat' placeholder='Apellido materno'>
            </div>
          </div>

          <div class='col-md-4'>
            <div class="form-group has-feedback">
              <i class="fa fa-user form-control-feedback"></i>
              <input type="text" class="form-control" id='ape_mat' name='ape_mat' placeholder='Apellido Paterno'>
            </div>
          </div>

          <div class='col-md-4'></div>

          <div class='col-md-12  mt-1'>
                <div class="row">

                      <div class='col-md-4'></div>
                      <div class='col-md-4'>
                        <div class="alert alert-info">
                            <strong>Datos extras</strong>
                        </div>
                      </div>
                      <div class='col-md-4'></div>
                 </div>
              </div>


          <div class='col-md-12' id='form_participante'>
             <div class="row">
                    <div class='col-md-3'>
                    </div>

                    <div class='col-md-3'>
                      <div class="form-group has-feedback">
                        <i class="fa fa-hashtag form-control-feedback"></i>
                        <input type="text" class="form-control" id='matricula' name='matricula' placeholder='Matricula'>
                      </div>


                    </div>
                    <div class='col-md-3'>
                        <div class="form-group has-feedback">
                            <i class="fa fa-graduation-cap form-control-feedback"></i>
                            <input type="text" class="form-control" id='programa' name='programa' placeholder='Programa'>
                          </div>

                    </div>
                    <div class='col-md-3'>

                    </div>
              </div>
          </div>


          <div class='col-md-12' id='form_visitante' style='display:none'>

          
          <div class="row">
                            

                            <div class='col-md-3'>
                              <div class="form-group has-feedback">
                                <i class="fa fa-hashtag form-control-feedback"></i>
                                <input type="text" class="form-control" id='identificador' name='identificador' placeholder='Identificador'>
                              </div>
                            </div>

                            <div class='col-md-3'>
                              <div class="form-group has-feedback">
                                <i class="fa fa-user-secret form-control-feedback"></i>
                                <input type="text" class="form-control" id='avisita' name='avisita' placeholder='A quien visita'>
                              </div>
                            </div>

                            <div class='col-md-3'>
                                <div class="form-group has-feedback">
                                    <i class=" 	fa fa-truck form-control-feedback"></i>
                                    <input type="text" class="form-control" id='donde' name='donde' placeholder='De donde nos visita'>
                                  </div>

                            </div>
                            <div class='col-md-3'>
                                  <div class="form-group has-feedback">
                                    <i class=" 		fa fa-question form-control-feedback"></i>
                                    <input type="text" class="form-control" id='motivo' name='motivo' placeholder='Motivo'>
                                  </div>

                            </div>
          </div>



          </div>

          <div class='col-md-12' id='form_empleado' style='display:none'>

                  <div class="row">
                            <div class='col-md-3'>
                            </div>

                            <div class='col-md-3'>
                              <div class="form-group has-feedback">
                                <i class="fa fa-hashtag form-control-feedback"></i>
                                <input type="text" class="form-control" id='no_empleado' name='no_empleado' placeholder='N# empleado'>
                              </div>


                            </div>
                            <div class='col-md-3'>
                                <div class="form-group has-feedback">
                                    <i class="fa fa-building-o form-control-feedback"></i>
                                    <input type="text" class="form-control" id='area' name='area' placeholder='Area/Departamento'>
                                  </div>

                            </div>
                            <div class='col-md-3'>
                            </div>
                  </div>

       


          </div>



    </div>
    <div class='row'>
        <div class='col-md-3'>
          
        </div>
        <div class='col-md-3'>
            <button type="submit"  class="btn btn-block btn-outline-success">Guardar</button>

        </div>
        <div class='col-md-3'>
            <button type="button" class="btn btn-block btn-outline-success" data-toggle="modal" data-target="#myModal">Guardar y generar QR</button>

        </div>
        <div class='col-md-3'>
        </div>
    </div>

  </form>

</div>


<div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
            <div class="alert alert-success">
              <strong>Operación Exitosa.</strong> El registro se ha guardado .




            </div>
          <h4 class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <div class="alert alert-secondary">
              <strong>Comparte este QR para que el usuario registre su entrada.</strong>
            </div>
            <div class='row'>
              <div class='col-md-3'></div>
              <div class='col-md-4'>
              <img src='https://upload.wikimedia.org/wikipedia/commons/d/d7/Commons_QR_code.png'></img>
              </div>
            </div>
     

        
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>


</body>
<script src='./public/resources/js/alta.js'></script>

<script>
    $(document).ready(()=>{


    });
</script>

</html>

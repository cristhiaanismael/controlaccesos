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
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./public/resources/js/notify.min.js"></script>


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
<?=$menu?>




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
              <input type="text" class="form-control form-control2" required='required' id='nombre' name='nombre' placeholder='Nombre'>
            </div>
          </div>

          <div class='col-md-4'>
            <div class="form-group has-feedback">
              <i class="fa fa-user form-control-feedback"></i>
              <input type="text" class="form-control form-control2" id='ape_pat' name='ape_pat' placeholder='Apellido paterno'>
            </div>
          </div>

          <div class='col-md-4'>
            <div class="form-group has-feedback">
              <i class="fa fa-user form-control-feedback"></i>
              <input type="text" class="form-control form-control2" id='ape_mat' name='ape_mat' placeholder='Apellido materno'>
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
                        <input type="text" class="form-control form-control2" id='matricula' name='matricula' placeholder='Matricula'>
                      </div>


                    </div>
                    <div class='col-md-3'>
                        <div class="form-group has-feedback">
                            <i class="fa fa-graduation-cap form-control-feedback"></i>
                            <input type="text" class="form-control form-control2" id='programa' name='programa' placeholder='Programa'>
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
                                <input type="text" class="form-control form-control2" id='identificador' name='identificador' placeholder='Identificador'>
                              </div>
                            </div>

                            <div class='col-md-3'>
                              <div class="form-group has-feedback">
                                <i class="fa fa-user-secret form-control-feedback"></i>
                                <input type="text" class="form-control form-control2" id='avisita' name='avisita' placeholder='A quien visita'>
                              </div>
                            </div>

                            <div class='col-md-3'>
                                <div class="form-group has-feedback">
                                    <i class=" 	fa fa-truck form-control-feedback"></i>
                                    <input type="text" class="form-control form-control2" id='donde' name='donde' placeholder='De donde nos visita'>
                                  </div>

                            </div>
                            <div class='col-md-3'>
                                  <div class="form-group has-feedback">
                                    <i class=" 		fa fa-question form-control-feedback"></i>
                                    <input type="text" class="form-control form-control2" id='motivo' name='motivo' placeholder='Motivo'>
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
                                <input type="text" class="form-control form-control2" id='no_empleado' name='no_empleado' placeholder='N# empleado'>
                              </div>


                            </div>
                            <div class='col-md-3'>
                                <div class="form-group has-feedback">
                                    <i class="fa fa-building-o form-control-feedback"></i>
                                    <input type="text" class="form-control form-control2" id='area' name='area' placeholder='Area/Departamento'>
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
            <button type="button" id='alta_genera' class="btn btn-block btn-outline-success">Guardar y generar QR</button>

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
          <h4 class="modal-title">Crear acceso</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" style=''>
            <div class=''>
                  <div class='container'>

                        <div class="card mx-auto" style="width: 18rem;">
                          <img class="card-img-top" src='https://preregidiomas.uteq.edu.mx/Images/Error.png' style='display:none'  id='qr_imagen' alt="Card image cap">
                            <a id="downloadLink" href="#" style="display: none;" download="imagen_de_ejemplo.png"></a>
                            <div class="card-body">
                              <h5 class="card-title" id='nombre_completo'>aqui</h5>
                              <input type="hidden" id='id_usuario_val'>
                              <p class="card-text" id='' >
                                <strong>Creado:</strong> <b id='creted_at' ></b>
                                <br>
                                <strong id='status'></strong> 
                              </p>
                              <button class="btn btn-primary" id='btnDescargar' onclick='generaObj.dowloadImg()'>Descargar <i class='fa fa-download'></i></button>
                              <br>

                            </div>
                        </div>


                   
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
<script src='./public/resources/js/genera.js'></script>

<script src='./public/resources/js/alta.js'></script>

<script>
    $(document).ready(()=>{
      let generaObj=new genera();

    });
</script>

</html>

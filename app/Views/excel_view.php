<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Carga de archivos!</title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="<?=env('app.baseURL')?>public/resources/icami icon.ico"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.24/sweetalert2.css">-->


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- STYLES -->
    <style>
        .table-primary{
            background-color: #A3D3F1;
        }
        .timeline .tag {
    display: block;
    height: 30px;
    font-size: 13px;
    padding: 8px;
}
.timeline .tags {
    position: absolute;
    top: 15px;
    left: 0;
    width: 84px;
}
.timeline .block {
    margin: 0;
    border-left: 3px solid #e8e8e8;
    overflow: visible;
    padding: 10px 15px;
    margin-left: 105px;
}
ul.timeline li {
    position: relative;
    border-bottom: 1px solid #e8e8e8;
    clear: both;
}
.timeline .tag span {
    display: block;
    overflow: hidden;
    width: 100%;
    white-space: nowrap;
    text-overflow: ellipsis;
}


.list-unstyled {
    padding-left: 0;
    list-style: none;
}
dl, ol, ul {
    margin-top: 0;
    margin-bottom: 1rem;
}

.tag {
    line-height: 1;
    background: #1ABB9C;
    color: #fff !important;
}
.tag:after {
    content: " ";
    height: 30px;
    width: 0;
    position: absolute;
    left: 100%;
    top: 0;
    margin: 0;
    pointer-events: none;
    border-top: 14px solid transparent;
    border-bottom: 14px solid transparent;
    border-left: 11px solid #1ABB9C;
}
a {
    color: #5A738E;
    text-decoration: none;
}
.swal-height {
  height: 57vh;
}
.whithe{
    color: white;
}


#logo_user_details {
    width: 100%;
    float: left;
    height: 85px;
}
#user_details_menu {
    color: #a2bacc;
    margin: 0;
    padding: 0;
    width: 100%;
    float: left;
}



element.style {
}
#user_details {
    float: right;
    width: 350px;
    /* background: url(layout/site/user_details_bg.gif) no-repeat; */
    padding: 15px 0 0 12px;
    position: relative;
    top: 0;
    left: 0;
}
#user_details_menu li {
    margin: 0;
    padding: 0 0 5px;
    list-style: none;
    width: 100%;
    float: left;
}
#head {
    width: 100%;
    min-height: 1px;
    position: relative;
    top: 0;
    left: 0;
    z-index: 300;
    background-color: white;
}
#logo {
    float: left;
    margin: 0;
    padding: 13px 0 0 12px;
    float: left;
}

#logo a {
    display: block;
    width: 168px;
    height: 60px;
    text-indent: -3000px;
    overflow: hidden;
    background: url(./public/resources/logo_main_small.jpg) no-repeat;
}

    </style>

   
</head>
<body>

<div id="head">

                <div id="logo_user_details">

                    <h1 id="logo"><a href="#">Mi ICAMI</a></h1>

                    <div id="user_details">
                        <ul id="user_details_menu">
                        <li>Bienvenido <strong><?= $nombre?></strong></li>
                        
                        </ul>
                    </div>
                </div>

                
            </div>



<div class="container">
<a href="<?=env('LINK_SOI')?>" title="Ir la página anterior"><i class="fa fa-arrow-circle-left" style="font-size:38px;color:green"></i></a>
<h1>Upload Excel <h5>


    <div class="col-md-12">
        <ul class="list-unstyled timeline">
            <li>
                <div class="block">
                    <div class="tags">
                        <a href="" class="tag">
                            <span>Plantilla</span>
                        </a>
                    </div>
                    <div class="block_content">
                        <h2 class="title">
                            <a>¿Necesitas el formato?</a>
                        </h2>
                        <div class="byline">
                            <span>El siguiente documento contiene el formato correcto, esperado por el sistema. Se recomienda
                                utilizar el documento para evitar errores.

                            </span>
                        </div>
                        <p class="excerpt pt-3 mt-3">
                            <a href="./public/layout_carga.xlsx" target="_blank" class="btn btn-default"><i class="fa fa-file-excel-o"></i> Descargar Layout</a>
                        </p>
                    </div>
                </div>
            </li>
            <li>
                <div class="block">
                    <div class="tags">
                        <a href="" class="tag">
                            <span>Carga</span>
                        </a>
                    </div>
                    <div class="block_content">
                        <h2 class="title">
                            <a>¿Esta listo el documento?</a>
                        </h2>
                        <div class="byline">
                            <span>Seleccione el documento en formato (xlsx o xls) 
                                con los datos añadidos. Asigna un nombre de lista.</span> 
                        </div>
                        <p class="excerpt">
                            
                            <form enctype="multipart/form-data" id="formuploadajax" method="post" >

                            <div class='row'>
                                <div class='col-md-6'>
                                    <input type="file" name="upload" id="upload"  accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"  >
                                </div>
                                <div class='col-md-6'>
                                    <input type='text' name='nameList' id='nameList' placeholder='Nombre de la lista' class='form-control'>
                                </div>



                                <div class='col-md-4 pt-3 mt-3'>
                                </div>
                                <div class='col-md-4 pt-3 mt-3'>
                                    <br>
                                    <button type="submit" class="btn btn-info btn-block">Subir</button>
                                </div>
                                <div class='col-md-4 pt-3 mt-3'>
                                </div>



                            </div>



                            </form>
                        </p>
                    </div>
                </div>
            </li>
            <li>
                <div class="block">
                    <div class="tags">
                        <a href="" class="tag">
                            <span>Vista</span>
                        </a>
                    </div>
                    <div class="block_content" >
                        <div>
                            <strong id="esperando"  style="display:">Esperando datos...</strong>
                            <strong id="loading" style="display:none">Procesando datos <img width="20%" src="<?=getenv('app.baseURL')?>public/resources/loading.gif"></img> </strong>
                            
                        </div>



                        <div id="vista_upload" style="display:none">

                            <h2 class="title">
                                <a>Esta informacion se subio correctamente</a>
                            
                                

                            </h2>
                            <h5>
                                    <a href='<?= env('LINK_SOI')?>'  id='href_lista'>Ver todos los registros 
                                                                    <i class='fa fa-external-link'></i>
                                    </a>
                                </h5>
                            <p class="excerpt">
                                    <div id="" style>
                                           


                                            <div class="table-responsive">

                                                    <table  class="table table-hover">
                                                            <thead>
                                                                <tr class="table-primary">
                                                                    <th>Nombre</th>
                                                                    <th>Apellidos</th>
                                                                    <th>Titulo</th>
                                                                    <th>Puesto</th>
                                                                    <th>Email</th>
                                                                    <th>Empresa</th>
                                                                </tr>
                                                                <tbody id="mensaje_upload">
                                                                
                                                                </tbody>
                                                            </thead>
                                                    </table>

                                                    




                                            </div>
                                        
                                    </div>
                            </p>
                        </div>










                        <div id="vista_previa" style="display:none">

                            <h2 class="title">
                                <a>¿Los datos son correctos?</a>
                            </h2>
                            <div class="byline">
                                <span>Antes de guardar por favor confirme que sus datos estan configurados correctamente</span> 
                            </div>
                            <p class="excerpt">*Estos son los datos que posteriormente guardaremos
                                    <div id="view_prev" style>
                                            <div class="row">
                                                    <div class="col-md-3">
                                                    </div>
                                                    <div class="col-md-3">
                                                    <div class="alert alert-info" id='correctos'>
                                                            <strong>total de registros subiran!</strong>  <i class="	fa fa-hashtag"></i>n/a
                                                            registros
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="alert alert-danger" id='error'>
                                                            <strong>¡Error!</strong>  <i class="	fa fa-hashtag"></i>n/a
                                                            registros con error
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="alert alert-success" id='total'>
                                                            <strong>total de registros subiran!</strong>  <i class="	fa fa-hashtag"></i>n/a
                                                            registros
                                                        </div>
                                                    </div>
                                            </div>


                                            <div class="table-responsive"  style="width:100%; height:38rem; overflow: scroll;" id='table'>

                                                    <table  class="table table-hover" id='tabla_success'>
                                                            <thead>
                                                                <tr class="table-primary">
                                                                    <th>Nombre</th>
                                                                    <th>Apellidos</th>
                                                                    <th>Titulo</th>
                                                                    <th>Puesto</th>
                                                                    <th>Email</th>
                                                                    <th>Empresa</th>
                                                                </tr>
                                                                <tbody id="mensaje">
                                                                
                                                                </tbody>
                                                            </thead>
                                                    </table>

                                                    <table  class="table table-hover "  id='tabla_error' hidden >
                                                            <thead>
                                                                <tr class="table-primary">
                                                                    <th>Nombre</th>
                                                                    <th>Apellidos</th>
                                                                    <th>Titulo</th>
                                                                    <th>Puesto</th>
                                                                    <th>Email</th>
                                                                    <th>Empresa</th>
                                                                </tr>
                                                                <tbody id="data_error">
                                                                
                                                                </tbody>
                                                            </thead>
                                                    </table>




                                            </div>
                                            <div class="row">
                                                    <div class="col-md-3">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <button type="button" class="btn btn-success btn-block" id="export" >Exportar</button>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <button type="button" class="btn btn-danger btn-block" id='cancelar'>Cancelar</button>
                                                    </div>
                                                    <div class="col-md-3">
                                                    </div>
                                                    <textarea id='data_json' hidden ></textarea>
                                            </div>
                                    </div>
                            </p>
                        </div>
                    </div>
            </li>
        </ul>


    </div>
</div>


  <!--  <div class="container">
        
             <h1>Upload Excel <h5><a href="#"><i class="fa fa-file-excel-o"></i> Descargar Layout</a></h5> </h1>
             

        <div class="row">
            <div class="col-md-6">
                <form enctype="multipart/form-data" id="formuploadajax" method="post" >
                    <input type="file" name="upload" id="upload"  accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"  >
                    <br>
                        <button type="submit" class="btn btn-info btn-lg">Subir</button>

                </form>
            </div>
            <div></div>
            <div></div>

        </div>



        
        <div class="modal" id="myModal">
            <div class="modal-dialog">
            <div class="modal-content">
            
               
                <div class="modal-header">
                <h4 class="modal-title">Vista previa</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
      
                <div class="modal-body">
                    <div class="table-responsive">
                        <table  class="table table-hover">
                                <thead>
                                    <tr class="table-primary">
                                        <th>Nombre</th>
                                        <th>Apellidos</th>
                                        <th>Titulo</th>
                                        <th>Puesto</th>
                                        <th>Email</th>
                                        <th>Empresa</th>
                                    </tr>
                                    <tbody id="mensaje">
                                    
                                    </tbody>
                                </thead>
                        </table>
                    </div>
                </div>
                
               
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-success btn-block" id="export" >Exportar</button>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Cancelar</button>
                        </div>
                        <div class="col-md-4">
                        </div>
                    </div>

                
                </div>
                
            </div>
            </div>
        </div>
        


       
    </div>-->
    <script>
    $(document).ready(()=>{
        $("#formuploadajax").on("submit", e=>{
            e.preventDefault();
            if($("#upload").val()==null || $("#upload").val()==''){
                toastr.error( 'No selecciono ningún archivo', 'Error!');
                return 0;
            }else if($("#nameList").val()==null || $("#nameList").val()==''){
                toastr.error( 'Se necesita un nombre de lista', 'Error!');
                $("#nameList").focus();
                return 0;
            }
            $('#vista_upload').hide();

            $('#loading').show();
            $('#esperando').hide();
            let formData = new FormData(document.getElementById("formuploadajax"));
            let files = $('#upload')[0].files[0];
            let ext= $("#upload").val().substring($("#upload").val().lastIndexOf("."))
            formData.append('file',files);
            formData.append('ext',ext);

            let route='<?php echo getenv('app.baseURL');  ?>';
            $.ajax({
                url: route+"recibe",
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
	            processData: false
            })
            .done(res=>{
                $('#tabla_success').show();
                 $('#tabla_error').hide();
                $('#loading').hide();
                $('#esperando').hide();
                $('#vista_previa').show();
                $('#vista_upload').hide();
                res=JSON.parse(res);
                if(res.rows_error>0){
                    $("#upload").val(null);
                    $("#export").attr("disabled", true)

                }else{
                    $("#export").removeAttr('disabled')
                }
                $("#error").html(`<strong>¡Error!</strong>  <i class="	fa fa-hashtag"></i>${res.rows_error} registros  <a href='#loading' onclick='ver_error()'><i class='fa fa-eye'></i></a>`);
                $('#total').html(` <strong>¡Se subiran!</strong>  <i class="	fa fa-hashtag"></i>${res.rows_success}
                                                            registros  <a href='#loading' onclick='ver_correctos()'><i class='fa fa-eye'></i></a>`);
                $('#correctos').html(` <strong>Total</strong>  <i class="	fa fa-hashtag"></i>${res.rows_total}
                                                            registros`);                                           
                $("#mensaje").html( res.html);
                $('#data_json').val(JSON.stringify(res.json));
                $("#data_error").html( res.html_error);
            }).fail(()=>{
                alert_error();
                $('#loading').hide();
                $('#esperando').show();
                $('#vista_previa').hide();
                $("#error").html('');
                $('#correctos').html('');
                $('#total').html('');
                $("#mensaje").html( '');
                $("#upload").val(null);
                $("#nameList").val('');


            });
        });
        $('#export').click(()=>exportar());
        $('#cancelar').click(()=>cancel());
        $('#ver_error').click(()=>ver_error());
    });
    const exportar=(data_json)=>{
        $('#loading').show();
        $('#vista_previa').hide();

        if($("#nameList").val()==null || $("#nameList").val()==''){
                toastr.error( 'Se necesita un nombre de lista', 'Error!');
                $("#nameList").focus();
                return 0;
        }
        let  parameters={
                        'data': $('#data_json').val(),
                        'nameList':$("#nameList").val()
                        };
        let route='<?php echo getenv('app.baseURL');  ?>';
            $.ajax({
                url: route+"exportar",
                type: "POST",
                dataType: "html",
                data: parameters,
            })
            .done(res=>{
                res=JSON.parse(res);

                if(res.operation=='canceled'){
                    toastr.error( 'Algo fallo, revise el formato de su archivo', 'Error!');
                    cancel();



                }else{

                

                    toastr.success( 'Los datos han sido almacenados con éxito', 'Hecho!')
                    $('#loading').hide();
                    $('#vista_previa').hide();
                    $('#vista_upload').show();
                    console.log(res.html);
                    $("#mensaje_upload").html( res.html);
                    $("#nameList").val('')
                    $('#href_lista').attr('href', '<?= getenv('LINK_SOI');  ?>/view/'+res.idlist );
                }

            })
            .fail(()=>{
                cancel();
                toastr.error( 'Algo fallo, vuelva a intentar', 'Error!');
            });

    }
    const cancel=()=>{
            $('#loading').hide();
            $('#esperando').show();
            $('#vista_previa').hide();
            $("#error").html('');
            $('#correctos').html('');
            $('#total').html('');
            $("#mensaje").html( '');
            $("#upload").val(null);
            $("#nameList").val('')
    }
    const alert_error=()=>{
        Swal.fire({
            title: '<h1><strong>Ha ocurrido un error</strong></h1>',
            icon: 'error',
            html:`<h3><strong>Asegurese de</strong></h3>
                    <ul>
                        <li>No tener abierto el documento que intenta subir</li>
                        <li>Haber guardado el archivo</li>
                        <li>Si realizo cambios es necesario que vuelva a cargar el archivo</li>
                    </ul>`,
            focusConfirm: false,
            confirmButtonText:
                '<a href="?" class="whithe">OK</a>',
                width: '46em',
                customClass: 'swal-height'
        })
    }
    const ver_error=()=>{
        $('#tabla_success').hide();
        $('#tabla_error').show();
    }
    const ver_correctos=()=>{
        $('#tabla_success').show();
        $('#tabla_error').hide();
    }
    </script>

</body>
</html>

class genera{
    static selectAll(){
        $('.checkbox').attr('checked','checked')
    }
    getUsers(){
        $('#check_all').prop("checked", false)
        let tipo_usuario=$("#tipo_usuario").val();  
        $.ajax({
            type: 'GET',
            url: './alta/read/?tipo='+(tipo_usuario== 0 ? 1 : tipo_usuario),
            success: function(response, textStatus, jqXHR){
                let res=JSON.parse(response)
                genera.tabla(res.data);
            }
            ,error : function(xhr, status) {
            }
    
        });
    }
 
    static tabla(data) {

        
        var datatable= new DataTable('#myTable');
        datatable.destroy();
        let table='';
        if($('#tipo_usuario').val()==1 || $('#tipo_usuario').val()==0){
             table+=`
                    <thead>
                                    <tr>
                                        <th>#Id</th>
                                        <th>Nombre</th>
                                        <th>Apellido Pat</th>
                                        <th>Apellido Mat</th>
                                        <th>Matricula</th>
                                        <th>Programa</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody id='tbody'>
            `;
                for(let i=0; i<data.length; i++) {
                    table+=`<tr>
                                <td><input type='checkbox' class='checkbox' name='seleccionado[]' value='${data[i].id_usuario}' >${data[i].id_usuario}</td>

                                <td id='td_nombre_${data[i].id_usuario}'>${data[i].nombre}</td>
                                <td id='td_apepat_${data[i].id_usuario}'>${data[i].apellido_pat}</td>
                                <td id='td_apemat_${data[i].id_usuario}'>${data[i].apellido_mat}</td>
                                <td>${data[i].matricula}</td>
                                <td>${data[i].programa}</td>
                                <td><a  href="#myModal" onclick='generaObj.recuperaQr(${data[i].id_usuario})' ><i class='fa fa-qrcode'></i></a href='#'></td>

                        </tr>`;
                
                }
        }else if($('#tipo_usuario').val() ==2){
            table+=`
            <thead>
                            <tr>
                                 <th>#Id</th>
                                    <th>Nombre</th>
                                    <th>Apellido Pat</th>
                                    <th>Apellido Mat</th>
                                    <th>Identificador</th>
                                    <th>A quien visita</th>
                                    <th>De donde nos visita</th>
                                    <th>Motivo</th>
                                    <th>Options</th>

                            </tr>
                        </thead>
                        <tbody id='tbody'>
    `;
            for(let i=0; i<data.length; i++) {
                table+=`<tr>
                            <td><input type='checkbox' class='checkbox' name='seleccionado[]' value='${data[i].id_usuario}' >${data[i].id_usuario}</td>

                            <td id='td_nombre_${data[i].id_usuario}'>${data[i].nombre}</td>
                            <td id='td_apepat_${data[i].id_usuario}'>${data[i].apellido_pat}</td>
                            <td id='td_apemat_${data[i].id_usuario}'>${data[i].apellido_mat}</td>
                            <td>${data[i].identificador}</td>
                            <td>${data[i].aquien_v}</td>
                            <td>${data[i].proviene_de}</td>
                            <td>${data[i].motivo}</td>
                            <td><a  href="#myModal" onclick='generaObj.recuperaQr(${data[i].id_usuario})' ><i class='fa fa-qrcode'></i></a href='#'></td>

                    </tr>`;
            
            }
        }else if($('#tipo_usuario').val() ==3){
            table+=`
            <thead>
                            <tr>
                                 <th>#Id</th>
                                    <th>Nombre</th>
                                    <th>Apellido Pat</th>
                                    <th>Apellido Mat</th>
                                    <th>No# empleado</th>
                                    <th>Area</th>
                                    <th>Options</th>

                            </tr>
                        </thead>
                        <tbody id='tbody'>
    `;
            for(let i=0; i<data.length; i++) {
                table+=`<tr>
                            <td><input type='checkbox' class='checkbox' name='seleccionado[]' value='${data[i].id_usuario}' >${data[i].id_usuario}</td>

                            <td id='td_nombre_${data[i].id_usuario}'>${data[i].nombre}</td>
                            <td id='td_apepat_${data[i].id_usuario}'>${data[i].apellido_pat}</td>
                            <td id='td_apemat_${data[i].id_usuario}'>${data[i].apellido_mat}</td>
                            <td>${data[i].n_empleado}</td>
                            <td>${data[i].area}</td>
                            <td><a  href="#myModal" onclick='generaObj.recuperaQr(${data[i].id_usuario})' ><i class='fa fa-qrcode'></i></a href='#'></td>

                    </tr>`;
            
            }
        }


        table+=`</tbody>`;
        $('#myTable').html(table);

        setTimeout(function(){
            $('#myTable').DataTable({
                responsive: true
            });
        }, 1000)
    }

    static reset(){
        $('#id_usuario_val').val('');
        $('#fecha_entry').val('');
        $('#hour_ini').val('');
        $('#fecha_exit').val('');
        $('#hour_exit').val('');
        $('#creted_at').html('');
        $('#crearBtn').removeAttr('disabled','disabled');

    }
    dowloadImg(){
        let id=$('#id_usuario_val').val();
        var img = new Image();
        img.onload = function() {
            var canvas = document.createElement('canvas');
            var ctx = canvas.getContext('2d');
            canvas.width = img.width * 1.5;
            canvas.height = img.height * 1.5;
            ctx.drawImage(img, 0, 0);

            // Agregar el texto antes de convertir a imagen
            ctx.font = '15px Arial';  // Establece el tamaño de la fuente
            ctx.fillStyle = 'black';  // Establece el color del texto
            ctx.textAlign = 'center';  // Alineación horizontal
            ctx.textBaseline = 'middle';  // Alineación vertical
            
            // Agregar texto en el centro del canvas
            ctx.fillText($('#nombre_completo').html(), canvas.width / 2, 213);  // Ajusta las coordenadas según sea necesario
            var pngDataUrl = canvas.toDataURL('image/png');
            var link = document.createElement('a');
            link.href = pngDataUrl;
            link.download = 'qr_'+id+ '.png';  // Nombre del archivo de la imagen
            link.click();
        };
        img.src = $('#qr_imagen').attr('src') ;
    }
    desactivar(cerrar=true){
        let params = {
            'id_usuario': $('#id_usuario_val').val(),
        };

        $.ajax({
            type: 'POST',
            data: params,
            url: './desactivar',
            success: function(response, textStatus, jqXHR){
                let res=JSON.parse(response);

                if(res.status=='success'){
                    if(cerrar){
                        $('#myModal').modal('hide');
                    }
                    $.notify("El código QR ha sido desactivado con éxito.",  "success");
                }else{
                }
                console.log(res);
            }
            ,error : function(xhr, status) {
            }
        });
    }
    generaAll(){
        $.notify("Espere un momento mientras generamos los QR", "info");

        let selectedItems = $('input[name="seleccionado[]"]:checked').map(function() {
            return $(this).val();
          }).get();
        
        let params = {
            selectedItems
        };
        $.ajax({
            type: 'POST',
            data: params,
            url: './createall',
            success: function(response, textStatus, jqXHR){
                $(".notifyjs-corner").find('.notifyjs-wrapper').fadeOut();

                let res=JSON.parse(response);

                if(res.status=='success'){
                    $('#qr_imagen').prop('src',res.data.img);
                    $('#qr_imagen').show()
                    $('#bntNuevo').removeAttr('disabled');
                    $('#btnDesactivar').removeAttr('disabled');
                    $('#btnDescargar').removeAttr('disabled');
                    $('#creted_at').html(res.data.created_at)
                }else{
                    $('#qr_imagen').hide()

                }
                console.log(res);
                $.notify("los QR's se han terminado de crear", "Success");

            }
            ,error : function(xhr, status) {
            }
        });
    }
    generaQr(){
        let params = {
            'id_usuario': $('#id_usuario_val').val(),
            'date_entry':$('#fecha_entry').val(),
            'hour_entry':$('#hour_ini').val(),
            'date_exit': $('#fecha_exit').val(),
            'hour_exit':$('#hour_exit').val(),
        };
        $('#crearBtn').attr('disabled','disabled');
        $.ajax({
            type: 'POST',
            data: params,
            url: './create',
            success: function(response, textStatus, jqXHR){
                let res=JSON.parse(response);

                if(res.status=='success'){
                    $('#qr_imagen').prop('src',res.data.img);
                    $('#qr_imagen').show()
                    $('#bntNuevo').removeAttr('disabled');
                    $('#btnDesactivar').removeAttr('disabled');
                    $('#btnDescargar').removeAttr('disabled');
                    $('#creted_at').html(res.data.created_at)
                }else{
                    $('#qr_imagen').hide()

                }
                console.log(res);
            }
            ,error : function(xhr, status) {
            }
        });
    }

    regenerate(){
        $.notify("Espere un momento mientras regeneramos el QR", "info");
        this.desactivar(false);

        setTimeout(()=>{
         this.generaQr();  
        },3000);
    }

    recuperaQr(id_usuario){
        genera.reset();
        let params = {
            id_usuario
        };
        $('#id_usuario_val').val(id_usuario);
        $.ajax({
            type: 'POST',
            data: params,
            url: './verify',
            success: function(response, textStatus, jqXHR){
                let res=JSON.parse(response);
                $('#nombre_completo').html($('#td_nombre_'+id_usuario).html() + ' ' +  $('#td_apepat_'+id_usuario).html() + ' ' + $('#td_apemat_'+id_usuario).html() )
                if(res.status=='success'){
                    $('#qr_imagen').prop('src',res.data.img);
                    $('#qr_imagen').show()

                    $('#status').html((res.data.activo == 1 ? 'Activo' : 'Inactivo') )
                    $('#creted_at').html(res.data.created_at)

                    $('#crearBtn').attr('disabled','disabled');

                }else{
                    $('#qr_imagen').hide()
                    $('#bntNuevo').attr('disabled','disabled');
                    $('#btnDesactivar').attr('disabled','disabled');
                    $('#btnDescargar').attr('disabled','disabled');
                }
            }
            ,error : function(xhr, status) {
            }
    
        });
        $('#myModal').modal('show');
    }
}
let generaObj=new genera();
$(document).ready(()=>{
    generaObj.getUsers();
    $('#crearBtn').click(()=>generaObj.generaQr());
    $('#tipo_usuario').change(()=>generaObj.getUsers());
});
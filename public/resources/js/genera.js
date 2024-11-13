class genera{

    getUsers(){
        $.ajax({
            type: 'GET',
            url: './alta/read/?tipo='+1,
            success: function(response, textStatus, jqXHR){
                let res=JSON.parse(response)
                genera.tabla(res.data);
            }
            ,error : function(xhr, status) {
            }
    
        });
    }
    static tabla(data){

        let table='';
        for(let i=0; i<data.length; i++) {
            table+=`<tr>
                        <td>${data[i].id_usuario}</td>

                        <td id='td_nombre'>${data[i].nombre}</td>
                        <td id='td_apepat'>${data[i].apellido_pat}</td>
                        <td id='td_apemat'>${data[i].apellido_mat}</td>
                        <td>${data[i].matricula}</td>
                        <td>${data[i].programa}</td>
                        <td><a  href="#myModal" onclick='generaObj.recuperaQr(${data[i].id_usuario})' ><i class='fa fa-qrcode'></i></a href='#'></td>

                </tr>`;
        
        }
        $('#tbody').html(table)
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
    }
    dowloadImg(){
        var img = new Image();
        img.onload = function() {
            var canvas = document.createElement('canvas');
            var ctx = canvas.getContext('2d');
            canvas.width = img.width;
            canvas.height = img.height;
            ctx.drawImage(img, 0, 0);
            var pngDataUrl = canvas.toDataURL('image/png');
            var link = document.createElement('a');
            link.href = pngDataUrl;
            link.download = 'imagen.png';  // Nombre del archivo de la imagen
            link.click();
        };
        img.src = $('#qr_imagen').attr('src') ;
    }
    desactivar(){
        
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
                }else{
                    $('#qr_imagen').hide()

                }
                console.log(res);
            }
            ,error : function(xhr, status) {
            }
        });
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
                $('#nombre_completo').html($('#td_nombre').html() + ' ' +  $('#td_apepat').html() + ' ' + $('#td_apemat').html() )
                if(res.status=='success'){
                    $('#qr_imagen').prop('src',res.data.img);
                    $('#qr_imagen').show()

                    $('#status').html((res.data.activo == 1 ? 'Activo' : 'Inactivo') )
                    $('#creted_at').html(res.data.created_at)


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
});
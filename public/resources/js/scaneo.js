class scaneo{
    
    scaneoQr(){
        $('body').removeClass('.body');

        $("#qr").prop("disabled", "disabled");
        let code=$("#qr").val();
        let params = {
            code
        }
        scaneo.reset()
        $.ajax({
            type: 'POST',
            data: params,
            url: './scanner',
            success: function(response, textStatus, jqXHR){
                $("#qr").val('');
                let res=JSON.parse(response);
                console.log(res);
                //1 participante
                //2visitante
                //3 empleado

                if(res.status=='success'){
                    $('#audio_success')[0].play();
                    $('body').addClass('body');
                    $.notify(res.msg, "success");
                    if(res.data.type=='SALIDA'){
                        $('.md-8').removeClass('col-md-6')
                        $('.md-8').addClass('col-md-8')

                        $('#typelog').html('Hasta pronto')

                    }else{
                        $('#typelog').html('BIENVENIDO')
                        $('.md-8').removeClass('col-md-8')
                        $('.md-8').addClass('col-md-6')

                    }
                    if(res.data.tipo_usuario==1){
                        $('#welcom_participante').show();
                        $('#welcom_empleado').hide();
                        $('#welcom_visitante').hide();
                        scaneo.print_participante(res.data)
                    }else if(res.data.tipo_usuario==2){
                        $('#welcom_visitante').show();
                        $('#welcom_participante').hide();
                        $('#welcom_empleado').hide();
                        scaneo.print_visitante(res.data)

                    }else{
                        $('#welcom_visitante').hide();
                        $('#welcom_participante').hide();
                        $('#welcom_empleado').show();
                        scaneo.print_empleado(res.data);
                    }

                    let mysqlDate = res.data.date_scanner;
                    let dateObj = new Date(mysqlDate);
                    let hours = dateObj.getHours();  // Obtiene la hora (0-23)
                    let minutes = dateObj.getMinutes();  // Obtiene los minutos (0-59)
                   // let seconds = dateObj.getSeconds();  // Obtiene los segundos (0-59)
                    $('#datescanner').html(` ${hours}:${(minutes < 10 ? '0'+ minutes : minutes)}`);
                    $('#hour').show();
                }else{
                    $.notify(res.msg, "error");
                    $('#audio_error')[0].play();
                    $('body').addClass('body_error');
                }

                setTimeout(()=>{
                    $('#qr').removeAttr('disabled');
                    $('#qr').focus();
                    $('body').removeClass('body');
                    $('body').removeClass('body_error');

                }, 800);
            }
            ,error : function(xhr, status) {
                $("#qr").val('');
                setTimeout(()=>{
                    $('#qr').removeAttr('disabled');
                    $('#qr').focus();
                }, 500);
            }
        });
    }
    static reset(){
        $('#welcom_visitante').hide();
        $('#welcom_participante').hide();
        $('#welcom_empleado').hide();
        $('#name_participante').html('' )
        $('#programa').html('')
        $('#name_empleado').html( ''  )
        $('#depto').html( '')
        $('#puesto').html( '')
        $('#name_visita').html( ''  )
        $('#visita').html( '' )
        $('#motivo').html( '')
        $('#hour').hide();

    }
    static print_participante(data){
        $('#name_participante').html(`${data.nombre} ${data.apellido_pat} ${data.apellido_mat} ` )
        $('#programa').html(`${data.programa}` )

    }
    static print_empleado(data){
        $('#name_empleado').html(`${data.nombre} ${data.apellido_pat} ${data.apellido_mat} ` )
        $('#depto').html(`${data.area}` )
        $('#puesto').html(`${data.puesto}`)
    }
    static print_visitante(data){
        $('#name_visita').html(`${data.nombre} ${data.apellido_pat} ${data.apellido_mat} ` )
        $('#visita').html(`${data.aquien_v}` )
        $('#motivo').html(`${data.motivo}`)
    }

}
let objScaneo = new scaneo();
$(document).ready(e=>{

    $('#form_scanner').submit(e=>{
        e.preventDefault();
        if($('#qr').val().length>2){
            objScaneo.scaneoQr();

        }else{
            $('#qr').focus();
        }


    });
});
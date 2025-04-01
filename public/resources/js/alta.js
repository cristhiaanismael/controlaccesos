class Alta{

    //1 participante
    // 2 visitante
    //empleado
    validator(params){
        for(var i=0; i<params.length; i++){
            if($('#'+params[i]).val() ==''){
                console.log($('#'+params[i]))
                $('#'+params[i]).focus();
                return false;
            }
        }
        return true;
        
    }

   
    createUser(genera=false){

      let params=this.params_required();
        if(!params){
            return false;
        }
   
        $.ajax({
            type: 'POST',
           // dataType: 'json',
            data: params,
            url: './alta/create',
            success: function(response, textStatus, jqXHR){
                let res=JSON.parse(response);
                console.log(res);
                if(res.status=='success'){
                    $.notify(res.msj , "success");
                    $('#id_usuario_val').val(res.data.id_usuario);
                    $('#nombre_completo').html(res.data.nombre + ' ' + res.data.apellido_pat+ ' ' + res.data.apellido_mat);
                    if(genera){
                        alta.generaQr();
                    }

                }
                $('.form-control2').val('');
            }
            ,error : function(xhr, status) {
                $.notify(res.msj, "error");

            }
    
        });

    }

    generaQr(){
        let params = {
            'id_usuario': $('#id_usuario_val').val(),
            'date_entry':'',
            'hour_entry':'',
            'date_exit': '',
            'hour_exit':'',
        };
        $.ajax({
            type: 'POST',
            data: params,
            url: './create',
            success: function(response, textStatus, jqXHR){
                let res=JSON.parse(response);

                if(res.status=='success'){
                    $('#myModal').modal('show');

                    $('#qr_imagen').prop('src',res.data.img);
                    $('#qr_imagen').show()
                    $('#btnDescargar').removeAttr('disabled');
                    $('#creted_at').html(res.data.created_at)
                    $('#id_usuario_val').val('')
                }else{
                    $('#qr_imagen').hide()
                    $('#id_usuario_val').val('')

                }
                console.log(res);
            }
            ,error : function(xhr, status) {
            }
        });
    }

    params_required(){
        let params = {};
        let validator =true;

        if($('#tipo_usuario').val()==1){
            //participante
            validator=this.validator(['tipo_usuario', 'nombre', 'ape_pat', 'ape_mat', 'matricula', 'programa']);
             params = {
                'tipo_usuario': $('#tipo_usuario').val().trim(),
                'nombre':   $('#nombre').val().trim(),
                'ape_pat':  $('#ape_pat').val().trim(),
                'ape_mat':  $('#ape_mat').val().trim(),
                'matricula':    $('#matricula').val().trim(),
                'programa': $('#programa').val().trim(),
            };


        }else if($('#tipo_usuario').val().trim()==2){

            validator=this.validator(['tipo_usuario','nombre','ape_pat','ape_mat','avisita','donde','motivo']);
            //visitante
             params = {
                'tipo_usuario': $('#tipo_usuario').val().trim(),
                'nombre':   $('#nombre').val().trim(),
                'ape_pat':  $('#ape_pat').val().trim(),
                'ape_mat':  $('#ape_mat').val().trim(),
                'identificador':    $('#identificador').val().trim(),
                'avisita':  $('#avisita').val().trim(),
                'donde':    $('#donde').val().trim(),
                'motivo':   $('#motivo').val().trim(),
            };


        }else{
            //empleado
             params = {
                'tipo_usuario': $('#tipo_usuario').val().trim(),
                'nombre':   $('#nombre').val().trim(),
                'ape_pat':  $('#ape_pat').val().trim(),
                'ape_mat':  $('#ape_mat').val().trim(),
                'no_empleado':  $('#no_empleado').val().trim(),
                'area': $('#area').val().trim(),
            };
            validator=this.validator(['tipo_usuario','nombre','ape_pat','ape_mat','no_empleado','area']);


        }

        if(!validator){
            return false
        }


        params
        return params;


    }


}
let alta= new Alta();
let generaObj=new genera();

$(document).ready(()=>{

  $('#form_alta').submit(e=>{
    e.preventDefault();
    alta.createUser();
  });

  $('#alta_genera').click(()=>{
    alta.createUser(true);
  })


$('#tipo_usuario').change(()=>{


    if($('#tipo_usuario').val()=='2'){
        $('#form_empleado').hide();
        $('#form_visitante').show();
        $('#form_participante').hide();



    }
    else if($('#tipo_usuario').val()=='3'){
        $('#form_visitante').hide();
        $('#form_participante').hide();
        $('#form_empleado').show();


    }else{
        $('#form_participante').show();
        $('#form_empleado').hide();
        $('#form_visitante').hide();
    }
});
});
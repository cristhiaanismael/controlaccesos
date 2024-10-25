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

   
    createUser(){
       debugger;

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
                console.log(response);
            }
            ,error : function(xhr, status) {
            }
    
        });

    }

    params_required(){
        alert('validara')
        let params = {};
        let validator =true;
        console.log($('#tipo_usuario').val())

        if($('#tipo_usuario').val()==1){
            //participante
            validator=this.validator(['tipo_usuario', 'nombre', 'ape_pat', 'ape_mat', 'matricula', 'programa']);
             params = {
                'tipo_usuario': $('#tipo_usuario').val(),
                'nombre':   $('#nombre').val(),
                'ape_pat':  $('#ape_pat').val(),
                'ape_mat':  $('#ape_mat').val(),
                'matricula':    $('#matricula').val(),
                'programa': $('#programa').val(),
            };
            console.log(params)


        }else if($('#tipo_usuario').val()==2){

            validator=this.validator(['tipo_usuario','nombre','ape_pat','ape_mat','identificador','avisita','donde','motivo']);
            //visitante
             params = {
                'tipo_usuario': $('#tipo_usuario').val(),
                'nombre':   $('#nombre').val(),
                'ape_pat':  $('#ape_pat').val(),
                'ape_mat':  $('#ape_mat').val(),
                'identificador':    $('#identificador').val(),
                'avisita':  $('#avisita').val(),
                'donde':    $('#donde').val(),
                'motivo':   $('#motivo').val(),
            };
            console.log(params)


        }else{
            //empleado
             params = {
                'tipo_usuario': $('#tipo_usuario').val(),
                'nombre':   $('#nombre').val(),
                'ape_pat':  $('#ape_pat').val(),
                'ape_mat':  $('#ape_mat').val(),
                'no_empleado':  $('#no_empleado').val(),
                'area': $('#area').val(),
            };
            validator=this.validator(['tipo_usuario','nombre','ape_pat','ape_mat','no_empleado','area']);
            console.log(params)


        }

        console.log(params)

        if(!validator){
            return false
        }
        console.log(params)

        return params;


    }


}
let alta= new Alta();

$(document).ready(()=>{

  $('#form_alta').submit(e=>{
    e.preventDefault();
    alta.createUser();
  });


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
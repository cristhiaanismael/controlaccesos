
class Admin{
    
    static active(consulta=''){
        $('.nav-item').removeClass('bg-light');
        
        if(consulta=='movimientos'){
            $('#movimientos').addClass('bg-light');
        }else if(consulta=='resumido'){
            $('#resumido').addClass('bg-light');
        }else{
            $('#aforo').addClass('bg-light');
        }
    }
    consulta_aforo(){
        $('.contenedores').hide();
        $('#div_aforo').show();
        $('#option').val('aforo');


        $.ajax({
            type: 'GET',
            url: './aforo',
            success: function(response, textStatus, jqXHR){
                //let res=JSON.parse(response)
                Admin.tabla_Aforo(response.data)
            }
            ,error : function(xhr, status) {
            }
    
        });
    }

    static fecha(){
        const today = new Date();

        // Formatear la fecha como YYYY-MM-DD
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0'); // Los meses empiezan desde 0
        const dd = String(today.getDate()).padStart(2, '0'); // Añadir un 0 al día si es menor de 10
    
        // Formatear la fecha en el formato correcto para el input tipo date (YYYY-MM-DD)
        const formattedDate = `${yyyy}-${mm}-${dd}`;
        return formattedDate;
    }

    movimientos(){
        $('#option').val('movimientos');
        $('.contenedores').hide();
        $('#div_movientos').show();

        if($('#picker').val()==''){
            $('#picker').val(Admin.fecha)
        }

        $.ajax({
            type: 'GET',
            url: './movimientos/?fecha='+$('#picker').val(),
            success: function(response, textStatus, jqXHR){
                //let res=JSON.parse(response)
                Admin.tabla_Movimientos(response.data)
            }
            ,error : function(xhr, status) {
            }
    
        });
    }
    resumen(){
        $('#option').val('resumen');
        $('.contenedores').hide();
        $('#div_resumen').show();

        if($('#picker').val()==''){
            $('#picker').val(Admin.fecha)
        }

        $.ajax({
            type: 'GET',
            url: './resumen/?fecha='+$('#picker').val(),
            success: function(response, textStatus, jqXHR){
                //let res=JSON.parse(response)
                Admin.tabla_resumen(response.data)
            }
            ,error : function(xhr, status) {
            }
    
        });
    }


    static tabla_Aforo(data){
       
        var datatable= new DataTable('#table_realtime');
        datatable.destroy();
        let table='';
             table+=`
                    <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Hora entrada</th>
                                        <th>Tipo</th>
                                        <th>Otro</th>
                                    </tr>
                                </thead>
                                <tbody id='tbody'>
            `;
            let otro='';
                for(let i=0; i<data.length; i++) {
                    if(data[i].tipo_usuario==1){
                        otro=data[i].programa;
                    }else if(data[i].tipo_usuario==2){
                        otro=data[i].aquien_v + ' / '+ data[i].motivo

                    }else{
                        otro=data[i].area;

                    }
                    table+=`<tr>

                                <td id='td_nombre_${data[i].id_usuario}'>${data[i].nombre} ${data[i].apellido_pat} ${data[i].apellido_mat}</td>
                                <td id='td_apepat_${data[i].id_usuario}'>${data[i].date_scanner}</td>
                                <td id='td_apemat_${data[i].id_usuario}'>${data[i].tipo_user}</td>
                                <td id='td_apemat_${data[i].id_usuario}'>${otro}</td>

                        </tr>`;
                
                }

                table+=`</tbody>`;
                $('#table_realtime').html(table);
        
                setTimeout(function(){
                    var datatable= new DataTable('#table_realtime',{
                        buttons: [
                            {
                                extend: 'excel',
                                text: 'excel',
                                className: 'btn btn-success'
                            },
                            {
                                extend: 'print',
                                text: 'Imprimir',
                                className: 'btn btn-secondary'
                            }
                        ],
                        layout: {
                         
                            bottomStart: 'buttons'
                            },
                        responsive: true,

                    });
                    
                }, 700)
    }

    static tabla_Movimientos(data){
        var datatable= new DataTable('#table_movimientos');
        datatable.destroy();

        let table='';
             table+=`
                    <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Hora </th>
                                        <th>Tipo registro</th>
                                        <th>Tipo usuario</th>
                                        <th>Otro</th>
                                    </tr>
                                </thead>
                                <tbody id='tbody'>
            `;
            let otro='';
                for(let i=0; i<data.length; i++) {
                    if(data[i].tipo_usuario==1){
                        otro=data[i].programa;
                    }else if(data[i].tipo_usuario==2){
                        otro=data[i].aquien_v + ' / '+ data[i].motivo

                    }else{
                        otro=data[i].area;

                    }
                    table+=`<tr>

                                <td id='td_nombre_${data[i].id_usuario}'>${data[i].nombre} ${data[i].apellido_pat} ${data[i].apellido_mat}</td>
                                <td id='td_apepat_${data[i].id_usuario}'>${data[i].date_scanner}</td>
                                <td id='td_apemat_${data[i].id_usuario}'>${data[i].type}</td>

                                <td id='td_apemat_${data[i].id_usuario}'>${data[i].tipo_user}</td>
                                <td id='td_apemat_${data[i].id_usuario}'>${otro}</td>

                        </tr>`;
                
                }

                table+=`</tbody>`;
                $('#table_movimientos').html(table);
        
                setTimeout(function(){
                    var datatable= new DataTable('#table_movimientos',{
                        buttons: [
                            {
                                extend: 'excel',
                                text: 'excel',
                                className: 'btn btn-success'
                            },
                            {
                                extend: 'print',
                                text: 'Imprimir',
                                className: 'btn btn-secondary'
                            }
                        ],
                        layout: {
                         
                            bottomStart: 'buttons'
                            },
                        responsive: true,

                    });
                    
                }, 700)
    }

    static tabla_resumen(data){
        var datatable= new DataTable('#table_resumen');
        datatable.destroy();

        let table='';
             table+=`
                    <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th class='bg-success'>Tipo registro</th>
                                        <th class='bg-success'>Hora </th>
                                        <th class='bg-info'>Tipo registro</th>
                                        <th class='bg-info'>Hora </th>

                                        <th>Tipo usuario</th>
                                        <th>Otro</th>
                                    </tr>
                                </thead>
                                <tbody id='tbody'>
            `;
            let otro='';
                for(let i=0; i<data.length; i++) {
                    if(data[i].tipo_usuario==1){
                        otro=data[i].programa;
                    }else if(data[i].tipo_usuario==2){
                        otro=data[i].aquien_v + ' / '+ data[i].motivo

                    }else{
                        otro=data[i].area;

                    }


                    table+=`<tr>

                                <td id='td_nombre_${data[i].id_usuario}'>${data[i].nombre} ${data[i].apellido_pat} ${data[i].apellido_mat}</td>
                                <td id='td_apepat_${data[i].id_usuario}' class='bg-success' >${data[i].first_type}</td>
                                <td id='td_apemat_${data[i].id_usuario}' class='bg-success' >${data[i].first_scan_time}</td>

                                <td id='td_apepat_${data[i].id_usuario}' class='bg-info'>  ${ (data[i].first_scan_time == data[i].last_scan_time ? '' : data[i].last_type) }</td>
                                <td id='td_apemat_${data[i].id_usuario}' class='bg-info'> ${ (data[i].first_scan_time == data[i].last_scan_time ? '' : data[i].last_scan_time) } </td>


                                <td id='td_apemat_${data[i].id_usuario}'>${data[i].tipo_user}</td>
                                <td id='td_apemat_${data[i].id_usuario}'>${otro}</td>

                        </tr>`;
                
                }

                table+=`</tbody>`;
                $('#table_resumen').html(table);
        
                setTimeout(function(){
                    var datatable= new DataTable('#table_resumen',{
                        buttons: [
                            {
                                extend: 'excel',
                                text: 'excel',
                                className: 'btn btn-success'
                            },
                            {
                                extend: 'print',
                                text: 'Imprimir',
                                className: 'btn btn-secondary'
                            }
                        ],
                        layout: {
                         
                            bottomStart: 'buttons'
                            },
                        responsive: true,

                    });
                    
                }, 700)
    }

}

let admin = new Admin();
$(document).ready(()=>{
    admin.consulta_aforo();
    $('#picker').change(()=>{
        if($('#option').val()=='movimientos'){
                admin.movimientos();
        }else if($('#option').val()=='resumen'){
            admin.resumen();

        }
        
    })
});


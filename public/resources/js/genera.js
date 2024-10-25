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
                        <td>${data[i].nombre}</td>
                        <td>${data[i].apellido_pat}</td>
                        <td>${data[i].apellido_mat}</td>
                        <td>${data[i].matricula}</td>
                        <td>${data[i].programa}</td>
                </tr>`;
        
        }
        $('#tbody').html(table)
        setTimeout(function(){
            $('#myTable').DataTable();
        }, 1000)
    }
}

let generaObj=new genera();

$(document).ready(()=>{

  
    generaObj.getUsers();

});
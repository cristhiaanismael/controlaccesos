class scaneo{
    
    scaneoQr(){
        alert('scaner');
        let code=$("#qr").val();
        let params = {
            code
        }
        $.ajax({
            type: 'POST',
            data: params,
            url: './scanner',
            success: function(response, textStatus, jqXHR){
                let res=JSON.parse(response);

                if(res.status=='success'){
                }else{
                }
            }
            ,error : function(xhr, status) {
            }
        });
    }

}
let objScaneo = new scaneo();
$(document).ready(e=>{

    $('#form_scanner').submit(e=>{
        e.preventDefault();
        objScaneo.scaneoQr();


    });
});
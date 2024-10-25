<?php
function logger($jwt=null, $id_user=null, $details=null, $type='s/r', $action='s/r'){
      $logger=new \App\Models\LoggerAuthModel();  
      $data2 = [
        'date'=>date('Y-m-d h:m:s'),
        'data'=>$jwt,
        'id_user'=>$id_user,
        'details'=>$details,
        'type'=>$type,
        'action'=>$action
     ];
     $logger->insert($data2);

}
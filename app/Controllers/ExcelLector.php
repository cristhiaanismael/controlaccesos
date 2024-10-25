<?php
namespace App\Controllers;
use App\Models\ClistaModel;
use App\Models\CListaContactoModel;

class ExcelLector extends BaseController
{
    public $session=null;
    public $db;
    public function __construct(){

        $this->session= \Config\Services::session();
        helper('logger');
        $this->db = db_connect(); 
    }
    public function index()
    {        
    if( empty($this->session->get('id_user')) ){
        return redirect()->to(env('LINK_SOI_RAIZ').'/login'); 
    }else{
            return view('excel_view' , ['nombre'=> $this->session->get('nombrecompleto') ]);
        }
    }
    public function exportar(){
        if(!isset($_REQUEST['data']) or  $_REQUEST['data']==''){
            $response=[
                "operation"=>'canceled',
                'msj'=>'not parameters'
            ];
            $res=json_encode($response);
            logger(json_encode($_REQUEST), $this->session->get('id_user'), $res, 'error', 'exportar');

            echo $res;
            die();
        }
        $benchmark = \Config\Services::timer();
        $benchmark->start('render export');
        $namelist=filter_input(INPUT_POST, 'nameList', FILTER_SANITIZE_ENCODED);
        $namelist=str_replace('%20',' ', $namelist);

        $datos=json_decode($_REQUEST['data'],true);

        $ClistaModel = new ClistaModel();
        $CListaContactoModel = new CListaContactoModel();

        $this->db->transBegin();



        $data = [
            'id_sede'=> $this->session->get('id_sede'),
            'id_program'=>0,
            'nombre'=>$namelist,
            'script'=>'',
            'is_dynamic'=>0,
            'deleted'=>0,
            'created_by'=>1,
            'created_at'=>date('Y-m-d h:m:s'),
            'last_modified_by'=>1,
            'last_modified_at'=>date('Y-m-d h:m:s'),
        ];
        $idlist=$ClistaModel->insert_data($data);
        if(!$idlist){
            $response=[
                "operation"=>'canceled',
                'msj'=>'not insert'
            ];
            $lg=json_encode($log);
            $this->db->transRollback(); 
            
            logger(json_encode($data), $this->session->get('id_user'), $lg, 'error', 'exportar');
            echo $res;
            die();
        }



        //$idlist=$ClistaModel->insertID;
        foreach( $datos  as $r){
            if( !array_key_exists('Nombre(obligatorio)', $r) or !array_key_exists('Email(obligatorio)', $r)
            or !array_key_exists('Apellido', $r) or !array_key_exists('Empresa', $r)   or !array_key_exists('Puesto', $r)
             ){


               $response=[
                   "operation"=>'canceled',
                   'msj'=>'not parameters'
               ];
               $res=json_encode($response);
               logger(json_encode($_REQUEST), $this->session->get('id_user'), $res, 'error', 'exportar');
               $this->db->transRollback(); 

               echo $res;
               die();
           }


            if($r['Nombre(obligatorio)']=='NULL' or $r['Nombre(obligatorio)']==NULL or $r['Nombre(obligatorio)']=='' 
                  or $r['Email(obligatorio)']=='NULL' or $r['Email(obligatorio)']==NULL or $r['Email(obligatorio)']=='' ){
                continue;
            }
            $data2 = ['id_lista'=>$idlist,
                    'titulo'=>$r['Titulo'],
                    'nombre'=>$r['Nombre(obligatorio)'],
                    'apellidos'=>$r['Apellido'],
                    'email'=>strtolower($r['Email(obligatorio)']),
                    'razon_social'=>$r['Empresa'],
                    'puesto'=>$r['Puesto']
             ];

             $CListaContactoModel->insert_data($data2);



            $id[]=$CListaContactoModel->insert_data($data2);
            $FirstID=$id[0];
            $LastID=end($id);
         }
         $rows=$CListaContactoModel->get_rows($FirstID, $LastID);
         if(count($rows)<=1){

            
            $response=[
                "operation"=>'faill',
                'msj'=>'no hay datos para mostrar'
            ];
            $this->db->transRollback(); 

            $res=json_encode($response);
            logger(json_encode($_REQUEST), $this->session->get('id_user'), $res, 'error', 'exportar');

            echo $res;
            die();

         }

         
            $this->db->transCommit();

         $html='';
         $conteo=0;
         foreach($rows as $row){
           if ($conteo>=20 ){ break;}
            $html.="<tr>
                        <td>$row->nombre</td>
                        <td>$row->apellidos</td>
                        <td>$row->titulo</td>
                        <td>$row->puesto</td>
                        <td>$row->email</td>
                        <td>$row->razon_social</td>
                    </tr>";
            $conteo++;         
         }
         
        $benchmark->stop('render export');
         $response=[
            "html"=>$html,
            "idlist"=>$idlist,
            "timers" => $benchmark->getTimers()
        ];
        $res=json_encode($response);
        $log=['operation'=>'succes',
              'msj'=>'se guardaron '. count($rows). ' con el id de lista ' .$idlist];
        $lg=json_encode($log);
        logger(json_encode($_REQUEST['data']), $this->session->get('id_user'), $lg, 'sucess', 'exportar');

        echo $res;
    }
    public function ParseNull($value){
        $value=trim($value ?? '');
        if($value==NULL or $value=='' or $value=='0' or $value==' ' or $value=='null'){
            return '';
        }else{
            return $value;
        }
    }
    public function recibe()
    {
        $benchmark = \Config\Services::timer();
        $benchmark->start('render view');
        $namelist=str_replace('%',' ', $_REQUEST['nameList']);
        if (move_uploaded_file($_FILES["file"]["tmp_name"], "./".$namelist.''.$_REQUEST['ext'])) {
            $name=$namelist.''.$_REQUEST['ext'];
        } else {
           $response=[
                "html"=>"<tr><td>Problemas</td><td>al</td><td>subir</td><td>el </td><td>archivo</td>td>  </td></tr>",
                "html_error"=>'',
                "rows_total"=>0,
                "rows_success"=>(0),
                "rows_error"=>0,
                "json"=>''
             ];
            $res=json_encode($response);
            echo $res;
            $log=['operation'=>'fail',
            'msj'=>'no se pudo guardar el archivo '. $namelist];
            $lg=json_encode($log);

            logger(json_encode($_FILES["file"]), $this->session->get('id_user'), $lg, 'error', 'recibe');

            die();
        }
            require 'vendor/autoload.php';
            $filename = $name;
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
            $documento = $reader->load($filename);
            try {
                        # Recuerda que un documento puede tener múltiples hojas
                        # obtener conteo e iterar
                        $totalDeHojas = $documento->getSheetCount();

                        $arraykeys=[
                            "A"=>"Nombre(obligatorio)",
                            "B"=>"Apellido",
                            "C"=>"Titulo",
                            "D"=>"Puesto",
                            "E"=>"Email(obligatorio)",
                            "F"=>"Empresa",
                        ];

                        # Iterar hoja por hoja
                        for ($indiceHoja = 0; $indiceHoja < $totalDeHojas; $indiceHoja++) {
                            $hojaActual = ( $documento->getSheetByName('Datos') ==NULL ?  $documento->getSheet(0):  $documento->getSheetByName('Datos'));
                            $cont=$hojaActual->getHighestDataRow() ;   
                               # Iterar filas
                            $html="";
                            $html_error="";
                            $count=0;
                            $cont_error=0;
                            $total_rows=0;
                            $countjson=0;
                            $filas=1;//no importa si son vacias
                                foreach ($hojaActual->getRowIterator() as $fila) {
                                        $html.="<tr>";
                                        $html_error.="<tr>";
                                        $errors=false;

                                        $A=$hojaActual->getCell('A'.$filas )->getValue();
                                        $B=$hojaActual->getCell('B'.$filas )->getValue();
                                        $C=$hojaActual->getCell('C'.$filas )->getValue();
                                        $D=$hojaActual->getCell('D'.$filas )->getValue();
                                        $E=$hojaActual->getCell('E'.$filas )->getValue();
                                        $F=$hojaActual->getCell('F'.$filas )->getValue();
                                        $A12=$hojaActual->getCell('A13' )->getValue();

                                       if(
                                        self::ParseNull($A)=='' && self::ParseNull($B)=='' && self::ParseNull($C)==''&& self::ParseNull($D)=='' && self::ParseNull($E)==''&& self::ParseNull($F)==''
                                        
                                        ){
                                            $filas++;     
                                            continue;
                                        }
                                        if(
                                            self::ParseNull($A)!='' or self::ParseNull($B)!=''or self::ParseNull($C)!=''or self::ParseNull($D)!=''or self::ParseNull($E)!=''or self::ParseNull($F)!=''
                                            ){
                                            if($A!='Nombre(obligatorio)' or $B!='Apellido' or $C!='Titulo' or $D!='Puesto' or
                                               $E!='Email(obligatorio)' or $F!='Empresa'   
                                             ){
                                                $total_rows++;
                                            }
                                        }
                                        foreach ($fila->getCellIterator() as $celda) {
                                            # El valor, así como está en el documento
                                            $valorRaw = $celda->getValue();
                                            if(
                                                self::ParseNull($A)!='' or self::ParseNull($B)!=''or self::ParseNull($C)!=''or self::ParseNull($D)!=''or self::ParseNull($E)!=''or self::ParseNull($F)!=''
                                                
                                            ){
                                                    if($valorRaw=='Nombre(obligatorio)' or $valorRaw=='Apellido' or $valorRaw=='Titulo' or
                                                    $valorRaw=='Email(obligatorio)' or $valorRaw=='Email(obligatorio)' or $valorRaw=='Puesto' OR $valorRaw=='Empresa'   
                                                    ){
                                                        continue;
                                                    }
                                                    # Fila, que comienza en 1, luego 2 y así...
                                                    $fila = $celda->getRow();
                                                    # Columna, que es la A, B, C y así...
                                                    $columna = $celda->getColumn();

                                                    $clase="";
                                                    //comprobar que toda la fina no estew vacia ya que toda la fila vacia no cuenta
                                                    if($columna=='A' ){
                                                        if($valorRaw==NULL or $valorRaw=='' or $valorRaw=='0' or $valorRaw==' '){
                                                            $errors=true;
                                                            $cont_error++;
                                                            $cont--;
                                                            $clase="alert-danger";

                                                        } 
                                                    }
                                                    
                                                    if($columna=='E' and !$errors){
                                                        if (!filter_var($valorRaw, FILTER_VALIDATE_EMAIL)) {
                                                            $errors=true;
                                                            $cont_error++;
                                                            $cont--;
                                                            $clase="alert-danger";
                                                        }else if($valorRaw==NULL or $valorRaw=='' or $valorRaw=='0' or $valorRaw==' '){//si una celda esta vacia
                                                            $errors=true;
                                                            $cont_error++;
                                                            $cont--;
                                                            $clase="alert-danger";

                                                        } 
                                                    }
                                                    if($columna<'G'  ){
                                                        if($count<6){
                                                            $html.="<td class='$clase'>".($valorRaw == NULL? "N/A": $valorRaw )."</td>";
                                                           // var_dump($countjson);
                                                            
                                                        }
                                                        if( $clase=="alert-danger"){
                                                            $html_error.="<td class='$clase'>".($A == NULL? "N/A": $A )."</td>";
                                                            $html_error.="<td class='$clase'>".($B == NULL? "N/A": $B )."</td>";
                                                            $html_error.="<td class='$clase'>".($C == NULL? "N/A": $C )."</td>";

                                                            $html_error.="<td class='$clase'>".($D == NULL? "N/A": $D )."</td>";
                                                            $html_error.="<td class='$clase'>".($E == NULL? "N/A": $E )."</td>";
                                                            $html_error.="<td class='$clase'>".($F == NULL? "N/A": $F )."</td>";
                                                            $countjson--;
                                                        }
                                                        $json[$countjson][$arraykeys[$columna]]=$valorRaw;
                                                    }
                                             }
                                        }
                                        $html.="</tr>";
                                        $html_error.="</tr>";
                                        $count=$count + ($valorRaw == NULL? 0 : 1 );
                                        $countjson++;

                                 $filas++;       
                                
                            }
                          
                            
                        }
                        
                        $benchmark->stop('render view');

                        $response=[
                            "html"=>$html,
                            "html_error"=>$html_error,
                            "rows_total"=>$total_rows,
                            "rows_success"=>($total_rows-$cont_error) ,
                            "rows_error"=>$cont_error,
                            "json"=>$json,
                            "timers" => $benchmark->getTimers()

                        ];
                        
                        $res=json_encode($response);
                        echo $res;

                        $log=['operation'=>'succes',
                            'msj'=>'El archido fue leido con '. $total_rows. ' registros totales '. $cont_error .' con error' ];
                        $lg=json_encode($log);
                        logger(json_encode($_FILES["file"]), $this->session->get('id_user'), $lg, 'sucess', 'recibe');






            } catch (\Exception $e) {
                echo 'Ocurrio un error al intentar abrir el archivo ' . $e;
                $log=['operation'=>'fail',
                    'msj'=>'hubo error al leer el archivo',
                    'description'=> ' '. $e];
                $lg=json_encode($log);
                logger(json_encode($_FILES["file"]), $this->session->get('id_user'), $lg, 'error', 'recibe');

            }
    }
}

<?php

namespace App\Controllers;

use App\Models\UserModel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use CodeIgniter\Controller;

class ExcelLector extends BaseController
{
    public $session = null;
    public $db;
    public $model;

    public function __construct()
    {
        helper('logger');
        if (!session()->has('id_operador')) {
            header('Location: ./');
            exit;
        }
        
        $this->db = \Config\Database::connect();
        $this->model = new UserModel();
    }

    public function index()
    {
        return view('Masiva_view', ['nombre' => '']);
    }

    public function recibe()
    {
        // Iniciar temporizador
        $benchmark = \Config\Services::timer();
        $benchmark->start('render view');
    
        $filepath = "./" . basename($_FILES["file"]["name"]);
    
        // Mover el archivo a la ubicación correcta
        if (!move_uploaded_file($_FILES["file"]["tmp_name"], $filepath)) {
            echo json_encode([
                "html" => "<tr><td colspan='8' class='alert-danger'>Error al subir el archivo</td></tr>",
                "html_error" => '',
                "rows_total" => 0,
                "rows_success" => 0,
                "rows_error" => 0,
                "json" => ''
            ]);
            die();
        }

        // Cargar la librería PhpSpreadsheet
        require 'vendor/autoload.php';
        $reader = IOFactory::createReader("Xlsx");
        $documento = $reader->load($filepath);

        try {
            $hoja = $documento->getSheetByName('Datos') ?: $documento->getSheet(0);
            $filasTotales = $hoja->getHighestDataRow();
    
            $html = "";
            $html_error = "";
            $json = [];
            $total_rows = 0;
            $cont_error = 0;
    
            // Definir los encabezados para los diferentes tipos de usuarios
            $headers = [
                "A" => "nombre", "B" => "apellido_pat", "C" => "apellido_mat", 
                "D" => "matricula", "E" => "programa", "F" => "correo", "G" => "img", // Participantes
                "H" => "identificador", "I" => "aquien_v", "J" => "proviene_de", "K" => "motivo", // Visitantes
                "L" => "n_empleado", "M" => "area", "N" => "puesto" // Empleados
            ];
    
            // Procesar cada fila
            for ($fila = 2; $fila <= $filasTotales; $fila++) {
                $errors = false;
                $rowData = [];
                $rowHtml = "<tr>";
                $rowHtmlError = "<tr>";
    
                foreach ($headers as $col => $campo) {
                    $valor = trim(strval($hoja->getCell($col . $fila)->getValue()));
                    $clase = "";
    
                    // Validación de campos vacíos
                    if (empty($valor)) {
                        $clase = "alert-danger";
                        $errors = true; // Marca que esta fila tiene errores
                    } elseif ($campo == "correo" && !filter_var($valor, FILTER_VALIDATE_EMAIL)) {
                        $clase = "alert-danger";
                        $errors = true; // Marca que esta fila tiene errores
                    }
    
                    $rowHtml .= "<td class='$clase'>" . ($valor ?: "N/A") . "</td>";
                    $rowHtmlError .= "<td class='$clase'>" . ($valor ?: "N/A") . "</td>";
                    $rowData[$campo] = $valor;
                }
    
                $rowHtml .= "</tr>";
                $rowHtmlError .= "</tr>";
    
                $html .= $rowHtml;
                if ($errors) {
                    $html_error .= $rowHtmlError;
                    $cont_error++; // Incrementa el contador de errores solo si hay errores en la fila
                } else {
                    $json[] = $rowData;
                }
    
                $total_rows++;
            }

            // Validación de los datos antes de la inserción en la base de datos
            $erroresValidacion = [];
            foreach ($json as $index => $rowData) {
                if (!$this->validarCampos($rowData)) {
                    $erroresValidacion[] = [
                        'fila' => $index + 2, // fila en el archivo Excel
                        'errores' => ['Campos incompletos o inválidos']
                    ];
                    unset($json[$index]); // Eliminar filas con errores
                }
            }

            // Si hay errores de validación, mostrar los errores
            if ($erroresValidacion) {
                echo json_encode([
                    "html" => $html,
                    "html_error" => $html_error,
                    "rows_total" => $total_rows,
                    "rows_success" => ($total_rows - $cont_error),
                    "rows_error" => $cont_error,
                    "errores" => $erroresValidacion,
                    "json" => []
                ]);
                die();
            }

            // Si no hay errores de validación, insertamos los datos en la base de datos
            $success = 0;
            $failure = 0;
            foreach ($json as $data) {
                if ($this->insertData($data)) {
                    $success++;
                } else {
                    $failure++;
                }
            }

            // Respuesta con el procesamiento
            echo json_encode([
                "html" => $html,
                "html_error" => $html_error,
                "rows_total" => $total_rows,
                "rows_success" => $success,
                "rows_error" => $failure,
                "json" => $json,
                "timers" => $benchmark->getTimers()
            ]);

        } catch (\Exception $e) {
            // Manejo de excepciones
            echo json_encode([
                "html" => "<tr><td colspan='8' class='alert-danger'>Error al procesar el archivo: " . $e->getMessage() . "</td></tr>",
                "html_error" => '',
                "rows_total" => 0,
                "rows_success" => 0,
                "rows_error" => 0,
                "json" => ''
            ]);
        }
    }

    // Validación de los campos antes de insertarlos en la BD
    public function validarCampos($data)
    {
        if (empty($data['nombre']) || empty($data['apellido_pat']) || empty($data['correo'])) {
            return false; // Campos requeridos vacíos
        }

        if (isset($data['correo']) && !filter_var($data['correo'], FILTER_VALIDATE_EMAIL)) {
            return false; // Correo inválido
        }

        // Validación de campos según el tipo de usuario
        if (isset($data['n_empleado']) && (empty($data['n_empleado']) || empty($data['area']) || empty($data['puesto']))) {
            return false; // Campos faltantes para empleados
        }

        if (isset($data['matricula']) && (empty($data['matricula']) || empty($data['programa']))) {
            return false; // Campos faltantes para participantes
        }

        if (isset($data['identificador']) && (empty($data['identificador']) || empty($data['aquien_v']))) {
            return false; // Campos faltantes para visitantes
        }

        return true; // Todos los campos son válidos
    }

    // Inserción de datos en la base de datos
    public function insertData($data)
    {
        // Preparar los datos para la inserción
        $insertData = [
            'nombre'         => $data['nombre'],
            'apellido_pat'   => $data['apellido_pat'],
            'apellido_mat'   => $data['apellido_mat'],
            'n_empleado'     => $data['n_empleado'] ?? null,
            'area'           => $data['area'] ?? null,
            'puesto'         => $data['puesto'] ?? null,
            'correo'         => strtolower($data['correo']),
            'img'            => $data['img'] ?? null,
            'tipo_usuario'   => $data['tipo_usuario'],
            'created_by'     => session()->get('id_user') ?? 1,
            'created_at'     => date('Y-m-d H:i:s')
        ];

        // Insertar en la base de datos usando el modelo
        try {
            $this->model->insert($insertData);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}

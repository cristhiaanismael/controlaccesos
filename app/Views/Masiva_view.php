<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importar Excel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2>Importar Datos desde Excel</h2>
        
        <form id="import-form" enctype="multipart/form-data">
            <div class="form-group">
                <label for="user_type">Selecciona el Tipo de Usuario:</label>
                <select class="form-control" id="user_type" name="user_type" required>
                    <option value="" disabled selected>Selecciona el tipo de usuario</option>
                    <option value="empleado">Empleado</option>
                    <option value="participante">Participante</option>
                    <option value="visitante">Visitante</option>
                </select>
            </div>

            <div class="form-group">
                <label for="file">Selecciona el archivo Excel:</label>
                <input type="file" class="form-control" id="file" name="file" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Cargar</button>
        </form>

        <h3 class="mt-4">Resultado de la Carga</h3>
        <table class="table table-bordered" id="result-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Matricula/Empleado</th>
                    <th>Área</th>
                    <th>Puesto</th>
                    <th>Correo</th>
                    <th>Imagen</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aquí se insertarán las filas de datos -->
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('#import-form').on('submit', function(e) {
                e.preventDefault();

                // Obtener el tipo de usuario
                var userType = $('#user_type').val();
                if (!userType) {
                    alert('Por favor, selecciona el tipo de usuario.');
                    return;
                }

                // Añadir el tipo de usuario al FormData
                var formData = new FormData(this);
                formData.append('user_type', userType);

                $.ajax({
                    url: 'ExcelLector/recibe', // Cambia esta URL según la ruta correcta
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var result = JSON.parse(response);
                        $('#result-table tbody').empty();
                        
                        // Si hay errores, mostrarlos
                        if (result.html_error) {
                            $('#result-table tbody').append(result.html_error);
                        }
                        
                        // Si no hay errores, mostrar los datos procesados
                        if (result.html) {
                            $('#result-table tbody').append(result.html);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error en la carga del archivo');
                    }
                });
            });
        });
    </script>
</body>
</html>

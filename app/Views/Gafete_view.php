<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credencial de Empleado</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        /*background-color: #f0f0f0;*/
        }

        .credencial {
            width: 55mm;
            height: 90mm;
            border: 2px solid black;
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            padding: 6px;
            font-family: Arial, sans-serif;
            background-color: white;
            position: relative;
        }

        .perforacion {
            width: 5mm;
            height: 5mm;
            border: 1px solid black;
            border-radius: 50%;
            position: absolute;
            top: 3mm;
            left: 50%;
            transform: translateX(-50%);
            background-color: white;
        }

        .encabezado {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            margin-top: 8mm;
        }

        .logo {
            width: 30mm;
            height: auto;
        }

        .foto {
            width: 15mm;  /* Ancho ajustado */
            height: 25mm; /* Alto ajustado */
            border-radius: 1px;
            margin: 5px 0;
            object-fit: cover; /* Recorta la imagen si es necesario */
        }

        .info {
            width: 100%;
            text-align: center;
            font-size: 10px;
        }

        .info p {
            margin: 2px 0;
        }

        .nombre {
            font-size: 12px;
            font-weight: bold;
            text-align: center;
        }

        .qr {
            width: 25mm;
            height: 25mm;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            margin-bottom: 4px;
        }

        .qr img {
            width: 100%;
            height: auto;
        }

        /* Bloque flotante para tapar parte del QR */
        .overlay {
            position: absolute;
            width: 30mm; /* Ajusta el tamaño del bloque */
            height: 2mm;
            background-color: white; /* Fondo blanco para tapar */
            bottom: 0; /* Lo más abajo posible */
            left: 50%;
            transform: translateX(-50%); /* Centrado en la credencial */
        }

        @media print {
            body {
                background: none;
            }
            .credencial {
                border: 1px solid black;
                box-shadow: none;
            }
            .perforacion {
                border: 1px dashed black;
            }
        }
    </style>
</head>
<body>

    <div class="credencial">
        <div class="perforacion"></div>
        <div class="encabezado">
            <img src="../public/resources/img/LOGO-min.png" alt="Escudo de la Empresa" class="logo">
        </div>
        <img src="../img/<?=$datos['foto']?>" alt="Foto del Empleado" class="foto">
        <div class="info">
            <p class="nombre"><?=$datos['nombre']?></p>
            <?php if($datos['tipo']==3){?>
            <p><strong>No. Empleado:</strong> <?=$datos['numero']?></p>
            <p><strong>Área:</strong> <?=$datos['area']?></p>
            <p><strong>Puesto:</strong> <?=$datos['puesto']?></p>
            <?php
            }elseif ($datos['tipo']==2) {?>
                <p><strong>A quien visita:</strong> <?=$datos['aquien_v']?></p>
                <p><strong>Motivo de visita:</strong> <?=$datos['motivo']?></p>
                <p><strong>De donde nos visita:</strong> <?=$datos['proviene_de']?></p>
           <?php
            }
            ?>
        </div>
        <div class="qr">
            <img src="<?=$datos['qr']?>" alt="Código QR">
            <div class="overlay"></div> <!-- Capa blanca sobre el QR -->
        </div>
    </div>

    <?php
    $texto = "Hola, Armando Bienvenido a Icami";
?>
    <h1>Texto a Voz</h1>
    <button onclick="leerTexto()">Reproducir Audio</button>

    <script>
        function leerTexto() {
            let texto = <?php echo json_encode($texto); ?>; // Recibir el string de PHP
            let speech = new SpeechSynthesisUtterance();
            speech.text = texto;
            speech.lang = 'es-US'; // Ajusta el idioma si es necesario
            speech.volume = 1; // Volumen (0 a 1)
            speech.rate = 1; // Velocidad (0.1 a 10)
            speech.pitch = 0; // Tono (0 a 2)

            window.speechSynthesis.speak(speech);
        }
    </script>


</body>
</html>


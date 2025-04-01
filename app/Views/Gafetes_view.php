<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gafetes</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .pagina {
            display: flex;
            flex-wrap: wrap;
            width: 210mm;
            height: 297mm;
            padding: 10mm;
            box-sizing: border-box;
        }

        .credencial {
            width: 53mm;
            height: 86mm;
            border: 2px solid black;
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            padding: 6px;
            background-color: white;
            position: relative;
            margin: 5mm;
        }

        .perforacion {
            width: 3mm;
            height: 3mm;
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
            margin-top: 5mm;
        }

        .logo {
            width: 30mm;
            height: auto;
        }

        .foto {
            width: 15mm;
            height: 25mm;
            border-radius: 1px;
            margin: 5px 0;
            object-fit: cover;
        }

        .info {
            width: 100%;
            text-align: center;
            font-size: 10px;
        }

        .nombre {
            font-size: 15px;
            font-weight: bold;
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

        .overlay {
            position: absolute;
            width: 30mm;
            height: 2mm;
            background-color: white;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
        }

        @media print {
            body {
                background: none;
            }
            .pagina {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                align-items: center;
            }
            .credencial {
                border: 1px solid black;
                box-shadow: none;
            }
            .perforacion {
                border: 1px dashed black;
            }
        }

        @page {
    size: A4 portrait; /* O puedes usar landscape si prefieres horizontal */
    margin: 1cm; /* Ajusta los márgenes */
}
    </style>
</head>
<body id="body">

    <?php 
    $contador = 0;
    foreach ($datos as $usuario): 
        if ($contador % 6 == 0) {
            echo '<div class="pagina">';
        }
    ?>

        <div class="credencial">
            <div class="perforacion"></div>
            <div class="encabezado">
                 <img src="public/resources/img/LOGO-min.png" alt="Escudo de la Empresa" class="logo">
                 

            </div>
            <img src="img/<?= $usuario['foto'] ?>" alt="Foto del Empleado" class="foto">
            <div class="info">
                <p class="nombre"><?= $usuario['nombre'] ?></p>
                <?php if ($usuario['tipo'] == 3): ?>
                    <p><strong>No. Empleado:</strong> <?= $usuario['numero'] ?></p>
                    <p><strong>Área:</strong> <?= $usuario['area'] ?></p>
                    <p><strong>Puesto:</strong> <?= $usuario['puesto'] ?></p>
                <?php elseif ($usuario['tipo'] == 2): ?>
                    <p><strong>A quien visita:</strong> <?= $usuario['aquien_v'] ?></p>
                    <p><strong>Motivo de visita:</strong> <?= $usuario['motivo'] ?></p>
                    <p><strong>De donde nos visita:</strong> <?= $usuario['proviene_de'] ?></p>
                <?php elseif ($usuario['tipo'] == 1): ?>
                    <p style="font-size: 15px!important"><strong>Programa:</strong> <?= $usuario['programa'] ?></p>
                <?php endif; ?>
            </div>
            <div class="qr">
                <img src="<?= $usuario['qr'] ?>" alt="Código QR">
                <div class="overlay"></div>
            </div>
        </div>


    <?php 
        $contador++;
        if ($contador % 6 == 0) {
            echo '</div>';
        }
    endforeach;

    if ($contador % 6 != 0) {
        echo '</div>';
    }
    ?>


</body>
</html>

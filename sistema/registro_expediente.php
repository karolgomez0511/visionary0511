<?php
include_once "includes/header.php";
include_once "../conexion.php";
require_once('../TCPDF/tcpdf.php');

// Verifica si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recopila los datos del formulario
    $fecha = $_POST['inputFecha'];
    $nombrePaciente = $_POST['inputNombrePaciente'];
    $direccionPaciente = $_POST['inputDireccionPaciente'];
    $telefonoPaciente = $_POST['inputTelefonoPaciente'];
    $celularPaciente = $_POST['inputCelularPaciente'];
    $descripcion = $_POST['descripcion'];
    $fechaEntrega = $_POST['inputFechaEntrega'];
    $total = $_POST['inputTotal'];
    $aCuenta = $_POST['inputACuenta'];
    $resta = $_POST['inputResta'];
    $iva = $_POST['inputIVA'];

    // Inserta los datos en la base de datos (ajusta según tu estructura de base de datos)
    $query = "INSERT INTO tabla_recetas (fecha, nombre_paciente, direccion_paciente, telefono_paciente, celular_paciente, descripcion, fecha_entrega, total, a_cuenta, resta, iva) 
              VALUES ('$fecha', '$nombrePaciente', '$direccionPaciente', '$telefonoPaciente', '$celularPaciente', '$descripcion', '$fechaEntrega', '$total', '$aCuenta', '$resta', '$iva')";

    if (mysqli_query($conexion, $query)) {
        // Generar y guardar el código QR
        $codigo = uniqid(); // Puedes generar un código único (ajusta según tus necesidades)
        $nombreArchivoQR = '../qrcodes/qr_' . $codigo . '.png';
        QRcode::png($codigo, $nombreArchivoQR);

        // Crear el objeto TCPDF
        $pdf = new TCPDF();

        // Añadir una página al PDF
        $pdf->AddPage();

        // Agregar contenido al PDF (ajusta según tus necesidades)
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, 'Fecha: ' . $fecha, 0, 1);
        $pdf->Cell(0, 10, 'Nombre del Paciente: ' . $nombrePaciente, 0, 1);
        $pdf->Cell(0, 10, 'Dirección del Paciente: ' . $direccionPaciente, 0, 1);
        $pdf->Cell(0, 10, 'Teléfono del Paciente: ' . $telefonoPaciente, 0, 1);
        $pdf->Cell(0, 10, 'Celular del Paciente: ' . $celularPaciente, 0, 1);
        $pdf->Cell(0, 10, 'Descripción: ' . $descripcion, 0, 1);
        $pdf->Cell(0, 10, 'Fecha de Entrega: ' . $fechaEntrega, 0, 1);
        $pdf->Cell(0, 10, 'Total: ' . $total, 0, 1);
        $pdf->Cell(0, 10, 'A Cuenta: ' . $aCuenta, 0, 1);
        $pdf->Cell(0, 10, 'Resta: ' . $resta, 0, 1);
        $pdf->Cell(0, 10, 'IVA: ' . $iva, 0, 1);

        // Guardar el PDF en un archivo o mostrarlo en el navegador
        $pdf->Output('../sistema2/receta.pdf', 'D');

        echo "Receta guardada correctamente.";
    } else {
        echo "Error al guardar la receta: " . mysqli_error($conexion);
    }

    // Cierra la conexión a la base de datos
    mysqli_close($conexion);
}
?>


<!-- Resto de tu código HTML -->




<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Receta</title>
    <!-- Agrega enlaces a los estilos de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">

        <!-- Encabezado -->
        <div class="text-center mt-4">
            <h2>VISIONART HEALTH CENTER</h2>
            <p>Avenida Universidad No. 1653 Col. Hacienda de Guadalupe , Ciudad de México | Teléfono:55-17-77-21-92</p>
            <p>Horarios de Atención: Lunes- Viernes 09:00 AM - 20:00 PM </p>
        </div>

        <!-- Información del Paciente -->
        <div class="mt-4">
            <h4 class="text-primary text-center">Información del Paciente</h4>
            <form>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputFecha">Fecha</label>
                        <input type="date" class="form-control" id="inputFecha" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputNombrePaciente">Paciente</label>
                        <input type="text" class="form-control" id="inputNombrePaciente" placeholder="Nombre del Paciente" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputDireccionPaciente">Dirección</label>
                        <input type="text" class="form-control" id="inputDireccionPaciente" placeholder="Dirección del Paciente" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputTelefonoPaciente">Teléfono</label>
                        <input type="tel" class="form-control" id="inputTelefonoPaciente" placeholder="Teléfono del Paciente" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputCelularPaciente">Celular</label>
                        <input type="tel" class="form-control" id="inputCelularPaciente" placeholder="Número de Celular del Paciente" required>
                    </div>
                </div>
                <br><br>
                <!-- Detalle de la Receta -->
                <h4 class="text-primary text-center">Detalle de la Receta</h4>

                <br><br>
                <div class="form-group col-md-12">
                    <label for="descripcion">Descripción:</label>
                    <textarea type="text" class="form-control" id="descripcion" placeholder="Describe el producto "></textarea>
                </div>
                <br><br>

                <!-- Información de Entrega y Detalles Financieros -->
                <h4 class="text-primary text-center">Información de Entrega y Detalles Financieros</h4>
                <br><br>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputFechaEntrega">Fecha de Entrega</label>
                        <input type="date" class="form-control" id="inputFechaEntrega" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputTotal">Total</label>
                        <input type="number" class="form-control" id="inputTotal" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputACuenta">A Cuenta</label>
                        <input type="number" class="form-control" id="inputACuenta" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputResta">Resta</label>
                        <input type="number" class="form-control" id="inputResta" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputIVA">IVA (Impuesto al Valor Agregado)</label>
                        <input type="number" class="form-control" id="inputIVA" required>
                    </div>
                </div>

                <!-- Botón para generar la receta en PDF -->
                <div class="text-center mt-4">
                    <button class="btn btn-primary" id="btnGenerarPDF">Generar Receta en PDF</button>
                </div>

                <!-- Script para manejar la generación de PDF al hacer clic en el botón -->
                

                <!-- ... (Tu código HTML existente) ... -->

</body>

</html>

<!-- Script para manejar la generación de PDF al hacer clic en el botón -->
<script>
    function generarRecetaPDF() {
        // Obtener los valores del formulario
        var fecha = document.getElementById('inputFecha').value;
        var nombrePaciente = document.getElementById('inputNombrePaciente').value;
        var direccionPaciente = document.getElementById('inputDireccionPaciente').value;
        var telefonoPaciente = document.getElementById('inputTelefonoPaciente').value;
        var celularPaciente = document.getElementById('inputCelularPaciente').value;
        var descripcion = document.getElementById('descripcion').value;
        var fechaEntrega = document.getElementById('inputFechaEntrega').value;
        var total = document.getElementById('inputTotal').value;
        var aCuenta = document.getElementById('inputACuenta').value;
        var resta = document.getElementById('inputResta').value;
        var iva = document.getElementById('inputIVA').value;

        // Enviar datos al servidor mediante AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'guardar_receta.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Respuesta del servidor (puedes manejarla según tus necesidades)
                alert(xhr.responseText);
            }
        };

        // Construir los datos a enviar
        var datos = "fecha=" + fecha +
            "&nombrePaciente=" + nombrePaciente +
            "&direccionPaciente=" + direccionPaciente +
            "&telefonoPaciente=" + telefonoPaciente +
            "&celularPaciente=" + celularPaciente +
            "&descripcion=" + descripcion +
            "&fechaEntrega=" + fechaEntrega +
            "&total=" + total +
            "&aCuenta=" + aCuenta +
            "&resta=" + resta +
            "&iva=" + iva;

        // Enviar la solicitud al servidor
        xhr.send(datos);
        
        // Después de recibir la respuesta del servidor, puedes redirigir al usuario a la página del PDF o mostrar algún mensaje.
    }
</script>

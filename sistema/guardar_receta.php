<?php
include_once "../conexion.php";

// Recibe los datos del formulario
$fecha = $_POST['fecha'];
$nombrePaciente = $_POST['nombrePaciente'];
$direccionPaciente = $_POST['direccionPaciente'];
$telefonoPaciente = $_POST['telefonoPaciente'];
$celularPaciente = $_POST['celularPaciente'];
$descripcion = $_POST['descripcion'];
$fechaEntrega = $_POST['fechaEntrega'];
$total = $_POST['total'];
$aCuenta = $_POST['aCuenta'];
$resta = $_POST['resta'];
$iva = $_POST['iva'];

// Guardar los datos en la base de datos (ajusta según tu estructura de base de datos)
$sql = "INSERT INTO recetas (fecha, nombre_paciente, direccion_paciente, telefono_paciente, celular_paciente, descripcion, fecha_entrega, total, a_cuenta, resta, iva) 
        VALUES ('$fecha', '$nombrePaciente', '$direccionPaciente', '$telefonoPaciente', '$celularPaciente', '$descripcion', '$fechaEntrega', '$total', '$aCuenta', '$resta', '$iva')";

if (mysqli_query($conexion, $sql)) {
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
    // ... (agregar más celdas según sea necesario)

    // Guardar el PDF en un archivo o mostrarlo en el navegador
    $pdf->Output('../sistema2/receta.pdf', 'D');
    
    echo "Receta guardada correctamente.";
} else {
    echo "Error al guardar la receta: " . mysqli_error($conexion);
}

mysqli_close($conexion);
?>

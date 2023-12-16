<?php
// Incluir las configuraciones e inicializaciones necesarias
include_once "includes/header.php";
include "../conexion.php";
require_once('../TCPDF/tcpdf.php');

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recopilar los datos del formulario
    $fecha = $_POST['inputFecha'];
    $nombrePaciente = $_POST['inputNombrePaciente'];
    // ... (resto de los campos)

    // Insertar los datos en la base de datos (sustituye 'nombre_de_tabla' por el nombre real de tu tabla)
    $query = "INSERT INTO nombre_de_tabla (fecha, nombre_paciente, /*...otros campos...*/) VALUES ('$fecha', '$nombrePaciente', /*...otros valores...*/)";
    $result = mysqli_query($conexion, $query);

    // Verificar si la consulta fue exitosa
    if ($result) {
        // Crear el objeto TCPDF
        $pdf = new TCPDF();

        // Añadir una página al PDF
        $pdf->AddPage();

        // Agregar el contenido al PDF
        // ... (resto del código para agregar el contenido)

        // Guardar el PDF en un archivo o mostrarlo en el navegador
        $pdf->Output('../sistema2/receta.pdf', 'D');
        exit;
    } else {
        // Mostrar un mensaje de error si la consulta no fue exitosa
        echo "Error al insertar datos en la base de datos: " . mysqli_error($conexion);
    }
} else {
    // Redirigir a otra página si se accede directamente a este script sin enviar el formulario
    header("Location:../sistema/registro.php");
    exit;
}
?>

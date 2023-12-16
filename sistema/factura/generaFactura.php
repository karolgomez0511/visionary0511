<?php
session_start();
if (empty($_SESSION['active'])) {
    header('location: ../');
}
include "../../conexion.php";
if (empty($_REQUEST['cl']) || empty($_REQUEST['f'])) {
    echo "No es posible generar la factura.";
} else {
    $codCliente = $_REQUEST['cl'];
    $noFactura = $_REQUEST['f'];
    $consulta = mysqli_query($conexion, "SELECT * FROM configuracion");
    $resultado = mysqli_fetch_assoc($consulta);
    $ventas = mysqli_query($conexion, "SELECT * FROM factura WHERE nofactura = $noFactura");
    $result_venta = mysqli_fetch_assoc($ventas);
    $clientes = mysqli_query($conexion, "SELECT * FROM cliente WHERE idcliente = $codCliente");
    $result_cliente = mysqli_fetch_assoc($clientes);
    $productos = mysqli_query($conexion, "SELECT d.nofactura, d.codproducto, d.cantidad, p.codproducto, p.descripcion, p.precio FROM detallefactura d INNER JOIN producto p ON d.nofactura = $noFactura WHERE d.codproducto = p.codproducto");
    require_once 'fpdf/fpdf.php';

    $pdf = new FPDF('P', 'mm', array(80,250 ));
    $pdf->AddPage();
    $pdf->SetMargins(2, 0, 2);
    $pdf->SetTitle("Ventas");
    $pdf->SetFont('Arial', 'B', 9);

    
   

    // Ajustar posición Y para reducir espacio
    $pdf->SetY($pdf->GetY() - 7);
    
    // Centrar el logo en el ancho de la página
    $pdf->SetX(($pdf->GetPageWidth() - 60) / 2);
    $pdf->Image("../img/logo.png", null, null, 60,60, 'PNG');
   
    // Address Details
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(60, 5, utf8_decode("RFC: " . $resultado['dni']), 0, 1, 'L');
    $pdf->Cell(60, 5, utf8_decode("Teléfono: " . $resultado['telefono']), 0, 1, 'L');
    $pdf->Cell(60, 5, utf8_decode("Dirección: " . $resultado['direccion']), 0, 1, 'L');

    // Ticket and Date
    $pdf->Cell(30, 5, "Ticket: " . $noFactura, 0, 0, 'L');
    $pdf->Cell(30, 5, "Fecha: " . $result_venta['fecha'], 0, 1, 'R');

    // Customer Details
    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(60, 5, "Datos del cliente", 0, 1, 'L');
    $pdf->Cell(40, 5, "Nombre", 0, 0, 'L');
    
    $pdf->SetFont('Arial', '', 7);
    if ($_GET['cl'] == 1) {
        $pdf->Cell(40, 5, utf8_decode("Público en general"), 0, 0, 'L');
        $pdf->Cell(20, 5, utf8_decode("-------------------"), 0, 0, 'L');
        $pdf->Cell(60, 5, utf8_decode("-------------------"), 0, 1, 'L');
    } else {
        $pdf->Cell(40, 5, utf8_decode($result_cliente['nombre']), 0, 0, 'L');
     
    }
    $pdf->Ln();
    // Product Details
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(60, 5, "Detalle de Productos", 0, 1, 'L');
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(42, 5, 'Nombre', 0, 0, 'L');
    $pdf->Cell(8, 5, 'Cant', 0, 0, 'L');
    $pdf->Cell(10, 5, 'Precio', 0, 0, 'L');
    $pdf->Cell(8, 5, 'Total', 0, 1, 'L');
    $pdf->SetFont('Arial', '', 7);
    while ($row = mysqli_fetch_assoc($productos)) {
        $pdf->Cell(42, 5, utf8_decode($row['descripcion']), 0, 0, 'L');
        $pdf->Cell(8, 5, $row['cantidad'], 0, 0, 'L');
        $pdf->Cell(10, 5, number_format($row['precio'], 2, '.', ','), 0, 0, 'L');
        $importe = number_format($row['cantidad'] * $row['precio'], 2, '.', ',');
        $pdf->Cell(18, 5, $importe, 0, 1, 'L');
    }
    $pdf->Ln();
    // Total
    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(73, 5, 'Total: ' . number_format($result_venta['totalfactura'], 2, '.', ','), 0, 1, 'R');
    $pdf->Ln();
    

    
$pdf->Ln(); // Asegúrate de agregar un salto de línea antes del pie de página
$pdf->SetFont('Arial', 'I', 7);
$pdf->Cell(70, 5, utf8_decode("¡Gracias por su compra!"), 0, 1, 'C');
$pdf->Cell(70, 5, utf8_decode("Teléfono: (+52) 55-68-08-28-38"), 0, 1, 'C');
$pdf->Cell(75, 5, utf8_decode("Síguenos en redes sociales:FACEBOOK :Visionart Health Center"), 0, 1, 'C');
$pdf->Cell(65, 5, "Fecha y hora de emision: " . $result_venta['fecha'], 0, 1, 'R');


// ... (código previo)

$pdf->Ln();
$pdf->SetFont('Arial', '', 7);

// Información en el pie de página
$pdf->Cell(70, 7, utf8_decode("-----------Este documento no tiene validez fiscal.----------"), 0, 1, 'C');
$pdf->Cell(75, 9, utf8_decode("Para consultas y reclamos, contacte a nuestro servicio al cliente."), 0, 1, 'C');
$pdf->Cell(75, 9, utf8_decode("ATENCION A CLIENTES -- 55-68-08-28-38"), 0, 1, 'C');






$pdf->Output("compra.pdf", "I");









}
?>

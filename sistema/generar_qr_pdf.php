<?php
require_once('../TCPDF/tcpdf.php');
include_once "../codigo_qr/qrlib.php";

if (isset($_GET['codigo']) && isset($_GET['precio'])) {
    $codproducto = $_GET['codigo'];
    $precio = $_GET['precio'];

    // Create a unique filename for the QR code
    $qrFileName = 'qrcodes/' . $codproducto . '_qr.png';

    // Generate the QR code
    QRcode::png( "$codproducto", $qrFileName, QR_ECLEVEL_L, 1);

    // Create a PDF document
    $pdf = new TCPDF();
    $pdf->AddPage();

    // Add the QR code image to the PDF
    $pdf->Cell(0, 15, 'Codigo: ' . $codproducto, 0, 1);
    $pdf->Cell(0, 3, 'Precio: $' . $precio, 0, 0);
    $pdf->Image($qrFileName, 10, 31, 28, 28);
  

    // Output the PDF to the browser or save it to a file
    $pdf->Output("QR_Producto_$codproducto.pdf", 'I');
} else {
    // Handle the case when codproducto or precio is not set
    echo "Invalid parameters.";
}



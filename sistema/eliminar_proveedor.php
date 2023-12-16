<?php
include "../conexion.php";

if(isset($_GET['id'])) {
    $proveedorId = $_GET['id'];

    // Perform the deletion
    $deleteQuery = mysqli_query($conexion, "DELETE FROM proveedor WHERE proveedor = '$proveedorId'");

    if ($deleteQuery) {
        // Redirect back to the supplier list after successful deletion
        header("Location: lista_proveedor.php");
        exit();
    } else {
        // Handle deletion error, you might want to show an error message or redirect to an error page
        echo "Error deleting supplier: " . mysqli_error($conexion);
    }
} else {
    // If 'id' is not set in the URL parameters, redirect to an error page or the supplier list
    header("Location: lista_proveedor.php");
    exit();
}
?>

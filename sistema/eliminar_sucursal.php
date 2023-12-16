<?php
include "../conexion.php";

if (isset($_GET['id'])) {
    $sucursalId = $_GET['id'];

    // Perform the deletion
    $deleteQuery = mysqli_query($conexion, "DELETE FROM sucursales WHERE id = '$sucursalId'");

    if ($deleteQuery) {
        // Redirect back to the sucursal list after successful deletion
        header("Location: lista_sucursal.php");
        exit();
    } else {
        // Handle deletion error, you might want to show an error message or redirect to an error page
        echo "Error deleting sucursal: " . mysqli_error($conexion);
    }
} else {
    // If 'id' is not set in the URL parameters, redirect to an error page or the sucursal list
    header("Location: lista_sucursal.php");
    exit();
}
?>

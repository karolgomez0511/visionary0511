<?php
include_once "includes/header.php";
include "../conexion.php";

if(isset($_GET['id'])) {
    $proveedorId = $_GET['id'];

    // Use $proveedorId in your SQL query to fetch the supplier details
    $query = mysqli_query($conexion, "SELECT * FROM proveedor WHERE proveedor = '$proveedorId'");
    $data = mysqli_fetch_assoc($query);
}else{
    header("Location: proveedores.php");
    exit();
}

$updateMessage = ""; // Variable to store the update message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle the form submission for updating data
    $newMarca = $_POST['marca'];  // Assuming 'marca' is the field to be updated
    $query = mysqli_query($conexion, "UPDATE proveedor SET proveedor='$newMarca' WHERE proveedor = '$proveedorId'");

    if ($query) {
        $updateMessage = "¡ Actualizado con éxito!";
    } else {
        $updateMessage = "Error al actualizar: " . mysqli_error($conexion);
    }
}

?>

<!-- HTML form for editing supplier data -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="h3 mb-4 text-gray-800">Editar Marca Armazon</h1>

            <?php if (!empty($updateMessage)) { ?>
                <div class="alert alert-<?php echo (strpos($updateMessage, "Error") !== false) ? "danger" : "success"; ?>" role="alert">
                    <?php echo $updateMessage; ?>
                </div>
            <?php } ?>

            <form method="post" action="">
                <div class="form-group">
                    <label for="marca">Marca:</label>
                    <input type="text" class="form-control" id="marca" name="marca" value="<?php echo $data['proveedor']; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </form>
        </div>
    </div>
</div>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Rest of your code...

include_once "includes/footer.php";
?>

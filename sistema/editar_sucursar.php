<?php
include_once "includes/header.php";
include "../conexion.php";

if(isset($_GET['id'])) {
    $sucursalId = $_GET['id'];

    // Use $sucursalId in your SQL query to fetch the sucursal details
    $query = mysqli_query($conexion, "SELECT * FROM sucursales WHERE id = '$sucursalId'");
    $data = mysqli_fetch_assoc($query);
} else {
    header("Location: lista_sucursales.php");
    exit();
}

$updateMessage = ""; // Variable to store the update message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle the form submission for updating data
    $newNombre = $_POST['nombre'];
    $newDireccion = $_POST['direccion'];

    $query = mysqli_query($conexion, "UPDATE sucursales SET nombre='$newNombre', direccion='$newDireccion' WHERE id = '$sucursalId'");

    if ($query) {
        $updateMessage = "¡Actualizado con éxito!";
    } else {
        $updateMessage = "Error al actualizar: " . mysqli_error($conexion);
    }
}

?>

<!-- HTML form for editing sucursal data -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="h3 mb-4 text-gray-800">Editar Sucursal</h1>

            <?php if (!empty($updateMessage)) { ?>
                <div class="alert alert-<?php echo (strpos($updateMessage, "Error") !== false) ? "danger" : "success"; ?>" role="alert">
                    <?php echo $updateMessage; ?>
                </div>
            <?php } ?>

            <form method="post" action="">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $data['nombre']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="direccion">Dirección:</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $data['direccion']; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </form>
        </div>
    </div>
</div>

<?php
// Rest of your code...

include_once "includes/footer.php";
?>

<?php
ob_start(); // Start output buffering

include_once "includes/header.php";
include "../conexion.php";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $query = mysqli_query($conexion, "SELECT * FROM producto WHERE codproducto = $id");
    $result = mysqli_fetch_assoc($query);

    if (!$result) {
        header("Location: productos.php"); // Redirect if product not found
        exit();
    }
} else {
    header("Location: productos.php"); // Redirect if no ID provided
    exit();
}

// Check if the form is submitted for updating product
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : "";
    $precio = isset($_POST['precio']) ? $_POST['precio'] : "";
    $existencia = isset($_POST['existencia']) ? $_POST['existencia'] : "";

    // Update the product in the database
    $updateQuery = "UPDATE producto SET descripcion='$descripcion', precio='$precio', existencia='$existencia' WHERE codproducto=$id";
    if (mysqli_query($conexion, $updateQuery)) {
        header("Location: registro_producto.php"); // Redirect after successful update
        exit();
    } else {
        echo "Error updating product: " . mysqli_error($conexion);
    }
}

ob_end_flush(); // End output buffering and send the output to the browser

?>
<!-- Rest of your HTML content -->
<!-- Begin Page Content -->
<div class="container-fluid">

  <div class="row">
    <div class="col-lg-6 m-auto">

      <div class="card">
        <div class="card-header bg-primary">
          Modificar Producto
        </div>
        <form class="" action="" method="post">
        <div class="card-body bg-primary">
          <?php echo isset($alert) ? $alert : ''; ?>
          <div class="card-body">
        <form method="POST" action="">
        <label for="descripcion">Producto:  </label>
        <input type="text" name="descripcion" value="<?php echo isset($result['descripcion']) ? $result['descripcion'] : ""; ?>" required>
<br><br>
        <label for="precio">Precio: <br></label>
        <input type="number" name="precio" value="<?php echo isset($result['precio']) ? $result['precio'] : ""; ?>" required>
<br><br>
        <label for="existencia">Existencia:</label>
        <input type="number" name="existencia" value="<?php echo isset($result['existencia']) ? $result['existencia'] : ""; ?>" required>
<br><br>
        <button type="submit" class="btn btn-success">Actualizar</button>
    </form>
        </div>
      </div>
    </div>
  </div>


</div>


  </div>



<?php include_once "includes/footer.php"; ?>
<!-- Begin Page Content -->





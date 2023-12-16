<?php
include_once "includes/header.php";
include "../conexion.php";

if (!empty($_POST)) {
    $alert = "";

    if (empty($_POST['proveedor'])) {
        $alert = '<div class="alert alert-danger" role="alert">
                        El campo proveedor es obligatorio
                    </div>';
    } else {
        $proveedor = $_POST['proveedor'];
        $usuario_id = $_SESSION['idUser'];

        // Elimina la verificación del código de proveedor existente
        $query_insert = mysqli_query($conexion, "INSERT INTO proveedor(proveedor, usuario_id) values ('$proveedor', '$usuario_id')");

        if ($query_insert) {
            $alert = '<div class="alert alert-primary" role="alert">
                        Proveedor registrado
                    </div>';
        } else {
            $alert = '<div class="alert alert-danger" role="alert">
                        Error al registrar proveedor
                    </div>';
        }
    }
}
mysqli_close($conexion);
?>

<!-- ... -->

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card-header bg-primary text-white">
                Registro de Marca
            </div>
            <div class="card bg-primary">
                <form action="" autocomplete="off" method="post" class="card-body p-2">
                    <!-- Elimina el campo codproveedor del formulario -->
                    <div class="form-group">
                        <label for="proveedor">Marca</label>
                        <input type="text" placeholder="Ingrese nombre del proveedor" name="proveedor" id="proveedor" class="form-control">
                    </div>
                    <input type="submit" value="Guardar Proveedor" class="btn btn-primary">
                    <a href="lista_proveedor.php" class="btn btn-danger">Regresar</a>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<?php include_once "includes/footer.php"; ?>

<?php
include_once "includes/header.php";
include "../conexion.php";

if (!empty($_POST)) {
    $alert = "";

    if (empty($_POST['nombre']) || empty($_POST['direccion'])) {
        $alert = '<div class="alert alert-danger" role="alert">
                        Los campos nombre y dirección son obligatorios
                    </div>';
    } else {
        $nombre = $_POST['nombre'];
        $direccion = $_POST['direccion'];
       

        $query_insert = mysqli_query($conexion, "INSERT INTO sucursales(nombre, direccion) values ('$nombre', '$direccion')");

        if ($query_insert) {
            $alert = '<div class="alert alert-primary" role="alert">
                        Sucursal registrada
                    </div>';
        } else {
            $alert = '<div class="alert alert-danger" role="alert">
                        Error al registrar sucursal
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
                Registro de Sucursal
            </div>
            <div class="card bg-primary">
                <form action="" autocomplete="off" method="post" class="card-body p-2">
                    <div class="form-group">
                        <label for="nombre">Nombre de la Sucursal</label>
                        <input type="text" placeholder="Ingrese nombre de la sucursal" name="nombre" id="nombre" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="direccion">Dirección de la Sucursal</label>
                        <input type="text" placeholder="Ingrese dirección de la sucursal" name="direccion" id="direccion" class="form-control">
                    </div>
                    <input type="submit" value="Guardar Sucursal" class="btn btn-primary">
                    <a href="lista_sucursales.php" class="btn btn-danger">Regresar</a>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<?php include_once "includes/footer.php"; ?>

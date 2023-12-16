<?php
include_once "includes/header.php";
include "../conexion.php";
include_once "../codigo_qr/qrlib.php";

function generateQRCode($text, $fileName)
{
    QRcode::png($text, $fileName);
}

if (!empty($_POST)) {
    if (!empty($_POST)) {
        $alert = "";
        if (empty($_POST['proveedor']) || empty($_POST['producto']) || empty($_POST['precio']) || $_POST['precio'] < 0 || empty($_POST['precio_real']) || $_POST['precio_real'] < 0 || empty($_POST['cantidad']) || $_POST['cantidad'] < 0) {
            $alert = '<div class="alert alert-danger" role="alert">
                Todos los campos son obligatorios y deben tener valores válidos.
            </div>';
        } else {
        }


        $codigo = $_POST['codigo'];
        $proveedor = $_POST['proveedor'];
        $producto = $_POST['producto'];
        $precio = $_POST['precio'];
        $precioreal = $_POST['precio_real'];
        $cantidad = $_POST['cantidad'];
        $usuario_id = $_SESSION['idUser'];

        $query_proveedor = mysqli_query($conexion, "SELECT id FROM proveedor WHERE proveedor = '$proveedor'");
        $result_proveedor = mysqli_fetch_assoc($query_proveedor);

        $proveedor_id = $result_proveedor['id'];


        $query_insert = mysqli_query($conexion, "INSERT INTO producto(codigo, proveedor, descripcion, precio, precio_real, existencia, usuario_id, sucursal) values ('$codigo','$proveedor_id', '$producto', '$precio','$precioreal', '$cantidad','$usuario_id', 'default_value')");
        if ($query_insert) {
            $alert = '<div class="alert alert-success" role="alert">
            Producto Registrado
        </div>';

            // Obtener el ID del último producto insertado
            $ultimoId = mysqli_insert_id($conexion);

            // Generar el nombre único para el archivo QR
            $nombreArchivoQR = 'qr_' . $ultimoId . '.png';

            // Ruta donde se guardará el archivo QR (asegúrate de tener permisos de escritura)
            $rutaArchivoQR = '../qrcodes/' . $nombreArchivoQR;

            // Generar y guardar el código QR
            QRcode::png($codigo, $rutaArchivoQR);
        } else {
            $alert = '<div class="alert alert-danger" role="alert">
            Error al registrar el producto
        </div>';
        }
    }
}
?>

<!-- ... (your existing HTML code) -->



<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Panel de Administración</h1>
        <a href="lista_productos.php" class="btn btn-primary">Regresar</a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card">
                <div class="card-header bg-primary">
                    Nuevo Producto
                </div>
                <div class="card-body bg-primary">
                    <form action="" method="post" autocomplete="off">
                        <?php echo isset($alert) ? $alert : ''; ?>
                        <div class="form-group">
                            <label for="codigo">CODIGO</label>
                            <input type="text" placeholder="Ingrese código" name="codigo" id="codigo" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Marca</label>
                            <?php
                            $query_proveedor = mysqli_query($conexion, "SELECT proveedor FROM proveedor ORDER BY proveedor ASC");
                            $resultado_proveedor = mysqli_num_rows($query_proveedor);
                            mysqli_close($conexion);
                            ?>

                            <select id="proveedor" name="proveedor" class="form-control">
                                <?php
                                if ($resultado_proveedor > 0) {
                                    while ($proveedor = mysqli_fetch_array($query_proveedor)) {
                                        // code...
                                ?>
                                        <option value="<?php echo $proveedor['proveedor']; ?>"><?php echo $proveedor['proveedor']; ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="producto">Producto</label>
                            <input type="text" placeholder="Ingrese producto" name="producto" id="producto" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="precio_real">Precio Compra</label>
                            <input type="text" placeholder="Ingrese precio" class="form-control" name="precio_real" id="precio_real">
                        </div>
                        <div class="form-group">
                            <label for="precio">Precio Venta </label>
                            <input type="text" placeholder="Ingrese precio" class="form-control" name="precio" id="precio">
                        </div>
                        <div class="form-group">
                            <label for="cantidad">Cantidad</label>
                            <input type="number" placeholder="Ingrese cantidad" class="form-control" name="cantidad" id="cantidad">
                        </div>





                        <input type="submit" value="Guardar Producto" class="btn btn-primary">
                        <br><br>
                        <div id="qrContainer">

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->
<?php include_once "includes/footer.php"; ?>

<script src="../codigo_qr/qrcode.min.js"></script>
<script src="../sistema/js/qrcode.js"></script>
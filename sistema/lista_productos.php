<?php
include_once "includes/header.php";
include "../conexion.php";
include_once "../codigo_qr/qrlib.php";
require_once('../TCPDF/tcpdf.php');
?>

<div class="content">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="text-center text-white">Productos</h1>
            <br><br>
            <a href="registro_producto.php" class="btn btn-primary">Nuevo</a>
            <br><br>
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="table">
                    <thead class="thead-dark">
                        <tr>
                            <th>CODIGO</th>
                            <th>ID</th>
                            <th>PRODUCTO</th>
                            <th>PRECIO PUBLICO</th>
                            <th>MARCA</th>
                            <th>STOCK</th>

                            <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 1) { ?>
                                <th>ACCIONES</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "../conexion.php";

                        $query = mysqli_query($conexion, "SELECT * FROM producto");
                        $result = mysqli_num_rows($query);
                        if ($result > 0) {
                            while ($data = mysqli_fetch_assoc($query)) {
                                // Obtener el nombre del proveedor
                                $id_proveedor = $data['proveedor']; // Asume que hay una columna id_proveedor en la tabla producto
                                $query_proveedor = mysqli_query($conexion, "SELECT proveedor FROM proveedor WHERE id= $id_proveedor");
                                $proveedor = mysqli_fetch_assoc($query_proveedor);
                        ?>
                                <tr>
                                    <td><?php echo $data['codigo']; ?></td>
                                    <td><?php echo $data['codproducto']; ?></td>
                                    <td><?php echo $data['descripcion']; ?></td>
                                    <td><?php echo $data['precio']; ?></td>
                                    <td><?php echo $proveedor['proveedor']; ?></td>
                                    <td><?php echo $data['existencia']; ?></td>

                                    <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 1) { ?>
                                        <td>
                                            <a href="agregar_producto.php?id=<?php echo $data['codproducto']; ?>" class="btn btn-primary"><i class='fas fa-audio-description'></i></a>
                                            <a href="../sistema/generar_qr_pdf.php?codigo=<?php echo $data['codigo']; ?>&precio=<?php echo $data['precio']; ?>" class="btn btn-warning" target="_blank"> Etiqueta QR</a>
                                            <a href="editar_producto.php?id=<?php echo $data['codproducto']; ?>" class="btn btn-info"><i class='fas fa-edit'></i></a>
                                            <form action="eliminar_producto.php?id=<?php echo $data['codproducto']; ?>" method="post" class="confirmar d-inline">
                                                <button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i> </button>
                                            </form>
                                        </td>
                                    <?php } ?>
                                </tr>
                        <?php
                            }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include_once "includes/footer.php"; ?>

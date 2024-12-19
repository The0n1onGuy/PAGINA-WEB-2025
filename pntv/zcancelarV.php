<?php
include("conexion.php");

if (isset($_GET['id_venta'])) {
    $idventa = intval($_GET['id_venta']);
    $idprod = intval($_GET['id_producto']);
    $cantv = $_GET['cantidad_existencia'];

    $update_stock = "UPDATE productos SET cantidad_existencia = cantidad_existencia + $cantv WHERE id_producto = $idprod";
    if (mysqli_query($con, $update_stock)) {
        $delete_query = "DELETE FROM ventas WHERE id_venta = $idventa";
        if (mysqli_query($con, $delete_query)) {
            echo "<script>alert('Venta cancelada');</script>";
        } else {
            echo "<script>alert('Error al cancelar venta');</script>";
        }
    } else {
        echo "<script>alert('Error al actualizar stock');</script>";
    }
    

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cancelar una venta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Lista de ventas</h1>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cantidad</th>
                <th>Total</th>
                <th>Vendedor</th>
                <th>Cliente</th>
                <th>Producto</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = mysqli_query($con, "SELECT * FROM ventas");
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                    <td>{$row['id_venta']}</td>
                    <td>{$row['cantidad']}</td>
                    <td>{$row['total']}</td>
                    <td>{$row['id_empleado']}</td>
                    <td>{$row['id_cliente']}</td>
                    <td>{$row['id_producto']}</td>
                        <td>
                            <a href='zcancelarV.php?id_venta={$row['id_venta']}&id_producto={$row['id_producto']}&cantidad_existencia={$row['cantidad']}' class='btn btn-danger btn-sm'>Eliminar</a>

                        </td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
    <div class="d-flex flex-wrap justify-content-center gap-2 mt-4">
        <a href="ventas.php" class="btn btn-primary btn-lg shadow-sm px-5 py-2">Regresar al inicio</a>
    </div>
</div>
</body>
</html>

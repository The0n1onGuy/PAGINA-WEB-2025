<?php
include("conexion.php");

if (isset($_POST['proveedor'], $_POST['producto'], $_POST['cantidad'])) {
    $id_proveedor = $_POST['proveedor'];
    $id_producto = $_POST['producto'];
    $cantidad = (int)$_POST['cantidad'];


    if ($cantidad <= 0) {
        $message = "La cantidad debe ser mayor a 0.";
        $alert_class = "alert-danger";
    } else {
   
        $check_producto = mysqli_query($con, "
            SELECT * FROM productos 
            WHERE id_producto = '$id_producto' AND id_proveedor = '$id_proveedor'
        ");

        if (mysqli_num_rows($check_producto) > 0) {
 
            $update = mysqli_query($con, "
                UPDATE productos 
                SET cantidad_existencia = cantidad_existencia + $cantidad 
                WHERE id_producto = '$id_producto'
            ");

            if ($update) {
                $message = "Stock actualizado correctamente.";
                $alert_class = "alert-success";
            } else {
                $message = "Error al actualizar el stock. Intente de nuevo.";
                $alert_class = "alert-danger";
            }
        } else {
            $message = "El producto no pertenece al proveedor seleccionado.";
            $alert_class = "alert-warning";
        }
    }
} else {
    $message = "Todos los campos son obligatorios.";
    $alert_class = "alert-danger";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Stock</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="alert <?php echo $alert_class; ?> alert-dismissible fade show" role="alert">
        <?php echo $message; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <div class="d-grid gap-2 mt-3">
        <a href="contactar_proveedores.php" class="btn btn-primary">Regresar a Contactar Proveedores</a>
        <a href="index.php" class="btn btn-secondary">Volver al Inicio</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

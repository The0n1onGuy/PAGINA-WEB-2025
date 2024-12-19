<?php
include("conexion.php");

if (isset($_POST['id_proveedor'])) {
    $id_proveedor = $_POST['id_proveedor'];


    $query = mysqli_query($con, "SELECT id_producto, nombre_producto FROM productos WHERE id_proveedor = '$id_proveedor'");

    echo "<option value='' disabled selected>Seleccione un producto</option>";
    while ($row = mysqli_fetch_assoc($query)) {
        echo "<option value='{$row['id_producto']}'>{$row['nombre_producto']}</option>";
    }
}
?>

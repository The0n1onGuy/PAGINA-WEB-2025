<?php
include("conexion.php");
session_start(); 


if (isset($_SESSION['alert_message'])) {
    echo $_SESSION['alert_message'];
    unset($_SESSION['alert_message']); 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Venta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<form action="logica_venta.php" method="post">
<div class="container mt-5">
    <h1>Registrar Venta</h1>

    <div class="mb-3">
        <label class="form-label">Cliente</label>
        <select class="form-select" name="cliente" required>
            <option value="" disabled selected>Seleccione un cliente</option>
            <?php
   
            $clientes = mysqli_query($con, "SELECT * FROM clientes");
            while ($cli = mysqli_fetch_assoc($clientes)) {
                echo "<option value='{$cli['id_cliente']}'>{$cli['nombre']} {$cli['apellido']}</option>";
            }
            ?>
        </select>
    </div>


    <div class="mb-3">
        <label class="form-label">Empleado</label>
        <select class="form-select" name="empleado" required>
            <option value="" disabled selected>Seleccione un empleado</option>
            <?php

            $empleados = mysqli_query($con, "SELECT * FROM empleados");
            while ($emp = mysqli_fetch_assoc($empleados)) {
                echo "<option value='{$emp['id_empleado']}'>{$emp['nombre']}</option>";
            }
            ?>
        </select>
    </div>


    <div class="mb-3">
        <label class="form-label">Producto</label>
        <select class="form-select" name="producto" required>
            <option value="" disabled selected>Seleccione un producto</option>
            <?php
   
            $productos = mysqli_query($con, "SELECT * FROM productos");
            while ($prod = mysqli_fetch_assoc($productos)) {
                echo "<option value='{$prod['id_producto']}'>{$prod['nombre_producto']} (Stock: {$prod['cantidad_existencia']})</option>";
            }
            ?>
        </select>
    </div>

 
    <div class="mb-3">
        <label class="form-label">Cantidad</label>
        <input type="number" class="form-control" name="cantidad" min="1" required>
    </div>

   
    <div class="d-grid gap-2">
        <button type="submit" class="btn btn-primary">Registrar Venta</button>
        <a href="ventas.php" class="btn btn-secondary">Regresar al Inicio</a> 
    </div>
</div>
</form>
</body>
</html>

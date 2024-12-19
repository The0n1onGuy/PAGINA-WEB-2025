<?php
include("conexion.php");

if (isset($_POST['nombre'], $_POST['apellido'], $_POST['telefono'], $_POST['email'], $_POST['direccion'])) {
    mysqli_query($con, "INSERT INTO clientes (nombre, apellido, telefono, email, direccion) VALUES 
        ('{$_POST['nombre']}', '{$_POST['apellido']}', '{$_POST['telefono']}', '{$_POST['email']}', '{$_POST['direccion']}')");
    echo "<div class='alert alert-success'>Cliente agregado correctamente.</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agregar Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Agregar Cliente</h1>
    <form method="POST">
        <input type="text" name="nombre" placeholder="Nombre" class="form-control mb-2" required>
        <input type="text" name="apellido" placeholder="Apellido" class="form-control mb-2" required>
        <input type="text" name="telefono" placeholder="Teléfono" class="form-control mb-2" required>
        <input type="email" name="email" placeholder="Email" class="form-control mb-2" required>
        <input type="text" name="direccion" placeholder="Dirección" class="form-control mb-2" required>
        <button type="submit" class="btn btn-primary">Agregar Cliente</button>
        <a href="mostrar_cliente.php" class="btn btn-secondary">Regresar</a>
    </form>
</div>
</body>
</html>

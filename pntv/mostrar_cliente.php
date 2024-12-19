<?php
include("conexion.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mostrar clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Lista de clientes</h1>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Numero de telefono</th>
                <th>Correo electrónico</th>
                <th>Dirección</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = mysqli_query($con, "SELECT * FROM clientes");
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['id_cliente']}</td>
                        <td>{$row['nombre']}</td>
                        <td>{$row['apellido']}</td>
                        <td>{$row['telefono']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['direccion']}</td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
    <div class="d-flex flex-wrap justify-content-center gap-2 mt-4">
    <a href="index.php" class="btn btn-info btn-lg shadow-sm px-5 py-2 text-white">Regresar al inicio</a>
    <a href="agregar_cliente.php" class="btn btn-info btn-lg shadow-sm px-5 py-2 text-white">Agregar clientes</a>
    <a href="Zeliminar_C.php" class="btn btn-info btn-lg shadow-sm px-5 py-2 text-white">Eliminar clientes</a>
    </div>
</div>
</body>
</html>

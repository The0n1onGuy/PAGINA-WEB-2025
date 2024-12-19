<?php
include("conexion.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mostrar proovedores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Lista de proveedores</h1>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Empresa</th>
                <th>Contacto</th>
                <th>Telefono</th>
                <th>Correo</th>
                <th>Direccion</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = mysqli_query($con, "SELECT * FROM proveedores");
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['id_proveedor']}</td>
                        <td>{$row['nombre_empresa']}</td>
                        <td>{$row['contacto']}</td>
                        <td>{$row['telefono']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['direccion']}</td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
    <div class="d-flex flex-wrap justify-content-center gap-2 mt-4">
    <a href="index.php" class="btn btn-warning btn-lg shadow-sm px-5 py-2 text-white">Regresar</a>
    <a href="agregar_proveedor.php" class="btn btn-warning btn-lg shadow-sm px-5 py-2 text-white">Agregar proveedores</a>
    <a href="eliminar_proveedor.php" class="btn btn-warning btn-lg shadow-sm px-5 py-2 text-white">Eliminar proveedores</a>
    </div>
</div>
</body>
</html>
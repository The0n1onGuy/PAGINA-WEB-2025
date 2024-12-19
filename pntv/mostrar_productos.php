<?php
include("conexion.php");
?>
<?php
include("conexion.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mostrar Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Lista de Productos</h1>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = mysqli_query($con, "SELECT * FROM productos");
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['id_producto']}</td>
                        <td>{$row['nombre_producto']}</td>
                        <td>{$row['descripcion']}</td>
                        <td>{$row['precio']}</td>
                        <td>{$row['cantidad_existencia']}</td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
    <div class="d-flex flex-wrap justify-content-center gap-2 mt-4">
    <a href="index.php" class="btn btn-danger btn-lg shadow-sm px-5 py-2">Regresar</a>
    <a href="agregar_producto.php" class="btn btn-danger btn-lg shadow-sm px-5 py-2">Agregar Productos</a>
    <a href="eliminar.php" class="btn btn-danger btn-lg shadow-sm px-5 py-2">Eliminar Productos</a>
    </div>
</div>
</body>
</html>

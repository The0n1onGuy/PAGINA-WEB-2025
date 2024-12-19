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
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Puesto</th>
                <th>Fecha de contratacion</th>
                <th>Salario</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = mysqli_query($con, "SELECT * FROM empleados");
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['id_empleado']}</td>
                         <td>{$row['nombre']}</td>
                          <td>{$row['apellido']}</td>
                           <td>{$row['puesto']}</td>
                            <td>{$row['fecha_contratacion']}</td>
                             <td>{$row['salario']}</td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
    <div class="d-flex flex-wrap justify-content-center gap-2 mt-4">
    <a href="index.php" class="btn btn-success btn-lg shadow-sm px-5 py-2">Regresar</a>
    <a href="empleados_mas_ventas.php" class="btn btn-success btn-lg shadow-sm px-5 py-2">Empleados con Más Ventas</a>
    <a href="agregar_empleado.php" class="btn btn-success btn-lg shadow-sm px-5 py-2">Agregar empleados</a>
    <a href="eliminar_empleado.php" class="btn btn-success btn-lg shadow-sm px-5 py-2">Eliminar empleados</a>
    </div>
</>
</body>
</html>

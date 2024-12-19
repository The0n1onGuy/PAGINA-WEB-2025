<?php
include("conexion.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Empleados con Más Ventas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Empleados con Más Ventas</h1>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID Empleado</th>
                <th>Nombre</th>
                <th>Puesto</th>
                <th>Total de Ventas</th>
                <th>Fecha de Venta</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Consulta para obtener empleados con el total de ventas y fechas
            $query = mysqli_query($con, "
                SELECT 
                    e.id_empleado, 
                    e.nombre, 
                    e.puesto, 
                    SUM(v.cantidad) AS total_ventas,
                    GROUP_CONCAT(DISTINCT v.fecha_venta ORDER BY v.fecha_venta SEPARATOR ', ') AS fechas_venta
                FROM empleados e
                JOIN ventas v ON e.id_empleado = v.id_empleado
                GROUP BY e.id_empleado
                ORDER BY total_ventas DESC
            ");

            if (mysqli_num_rows($query) > 0) {
                while ($row = mysqli_fetch_assoc($query)) {
                    echo "<tr>
                            <td>{$row['id_empleado']}</td>
                            <td>{$row['nombre']}</td>
                            <td>{$row['puesto']}</td>
                            <td>{$row['total_ventas']}</td>
                            <td>{$row['fechas_venta']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>No hay ventas registradas.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <div class="d-grid gap-2 mt-3">
        <a href="mostrar_empleados.php" class="btn btn-secondary">Regresar a empleados</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

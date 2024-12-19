<?php
include("conexion.php");

// Verificar si se ha recibido el ID para eliminar
if (isset($_GET['id_empleado'])) {
    $id_empleado = intval($_GET['id_empleado']);
    $delete_query = "DELETE FROM empleados WHERE id_empleado = $id_empleado";
    if (mysqli_query($con, $delete_query)) {
        echo "<script>alert('Empleado eliminado correctamente');</script>";
    } else {
        echo "<script>alert('Error al eliminar el empleado');</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Empleados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Lista de Empleados</h1>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Puesto</th>
                <th>Fecha de Contratación</th>
                <th>Salario</th>
                <th>Acción</th>
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
                        <td>
                            <a href='eliminar_empleado.php?id_empleado={$row['id_empleado']}' class='btn btn-danger btn-sm'>Eliminar</a>
                        </td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
    <div class="d-flex flex-wrap justify-content-center gap-2 mt-4">
        <a href="mostrar_empleados.php" class="btn btn-success btn-lg shadow-sm px-5 py-2">Regresar</a>
    </div>
</div>
</body>
</html>
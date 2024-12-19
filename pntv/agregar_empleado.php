<?php
include("conexion.php");

if (isset($_POST['nombre'], $_POST['apellido'], $_POST['puesto'], $_POST['fecha_contratacion'], $_POST['salario'])) {

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $puesto = $_POST['puesto'];
    $fecha_contratacion = $_POST['fecha_contratacion'];
    $salario = $_POST['salario'];


    $insertar = mysqli_query($con, "
        INSERT INTO empleados (nombre, apellido, puesto, fecha_contratacion, salario)
        VALUES ('$nombre', '$apellido', '$puesto', '$fecha_contratacion', '$salario')
    ");

    if ($insertar) {
        $message = "Empleado agregado correctamente.";
        $alert_class = "alert-success";
    } else {
        $message = "Error al agregar el empleado. Intente nuevamente.";
        $alert_class = "alert-danger";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agregar Empleado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Agregar Empleado</h1>


    <?php if (isset($message)): ?>
        <div class="alert <?php echo $alert_class; ?> alert-dismissible fade show" role="alert">
            <?php echo $message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form method="POST" action="agregar_empleado.php">
        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" placeholder="Ej. Juan" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Apellido</label>
            <input type="text" name="apellido" class="form-control" placeholder="Ej. Perez" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Puesto</label>
            <input type="text" name="puesto" class="form-control" placeholder="Ej. Vendedor" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Fecha de Contratación</label>
            <input type="date" name="fecha_contratacion" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Salario</label>
            <input type="number" name="salario" class="form-control" placeholder="Ej. 15000" step="0.01" min="0" required>
        </div>
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">Agregar Empleado</button>
            <a href="mostrar_empleados.php" class="btn btn-secondary">Regresar a empleados</a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

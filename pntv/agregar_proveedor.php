<?php
include("conexion.php");

if (isset($_POST['nombre_empresa'], $_POST['contacto'], $_POST['telefono'], $_POST['email'], $_POST['direccion'])) {

    $nombre_empresa = $_POST['nombre_empresa'];
    $contacto = $_POST['contacto'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];


    $insertar = mysqli_query($con, "
        INSERT INTO proveedores (nombre_empresa, contacto, telefono, email, direccion)
        VALUES ('$nombre_empresa', '$contacto', '$telefono', '$email', '$direccion')
    ");

    if ($insertar) {
        $message = "Proveedor agregado correctamente.";
        $alert_class = "alert-success";
    } else {
        $message = "Error al agregar el proveedor. Intente de nuevo.";
        $alert_class = "alert-danger";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agregar Proveedor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Agregar Proveedor</h1>


    <?php if (isset($message)): ?>
        <div class="alert <?php echo $alert_class; ?> alert-dismissible fade show" role="alert">
            <?php echo $message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

   
    <form method="POST" action="agregar_proveedor.php">
        <div class="mb-3">
            <label class="form-label">Nombre de la Empresa</label>
            <input type="text" name="nombre_empresa" class="form-control" placeholder="Ej. Tech Solutions" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Contacto</label>
            <input type="text" name="contacto" class="form-control" placeholder="Ej. Manuel Rojas" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Teléfono</label>
            <input type="text" name="telefono" class="form-control" placeholder="Ej. 555-123-4567" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" placeholder="Ej. contacto@empresa.com" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Dirección</label>
            <input type="text" name="direccion" class="form-control" placeholder="Ej. Calle Falsa 123" required>
        </div>
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">Agregar Proveedor</button>
            <a href="mostrar_proveedores.php" class="btn btn-secondary">Regresar a proveedores</a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

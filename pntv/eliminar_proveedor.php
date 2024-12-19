<?php
include("conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_proveedor = $_POST['id_proveedor'];

    // Verifica que el ID no esté vacío
    if (!empty($id_proveedor)) {
        // Consulta para eliminar el proveedor
        $query = "DELETE FROM proveedores WHERE id_proveedor = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, 'i', $id_proveedor);
        
        if (mysqli_stmt_execute($stmt)) {
            $message = "Proveedor eliminado exitosamente.";
        } else {
            $message = "Error al eliminar el proveedor. Por favor, verifica el ID.";
        }

        mysqli_stmt_close($stmt);
    } else {
        $message = "Por favor, ingresa un ID válido.";
    }
}

// Obtener la lista de proveedores para mostrar en el formulario
$result = mysqli_query($con, "SELECT id_proveedor, nombre_empresa FROM proveedores");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Proveedor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Eliminar un Proveedor</h1>
    <?php if (isset($message)): ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>
    <form action="eliminar_proveedor.php" method="POST">
        <div class="mb-3">
            <label for="id_proveedor" class="form-label">Selecciona el proveedor a eliminar:</label>
            <select class="form-select" name="id_proveedor" id="id_proveedor" required>
                <option value="" selected>-- Selecciona un proveedor --</option>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <option value="<?php echo $row['id_proveedor']; ?>">
                        <?php echo $row['id_proveedor'] . " - " . $row['nombre_empresa']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-danger">Eliminar</button>
        <a href="mostrar_proveedores.php" class="btn btn-secondary">Regresar</a>
    </form>
</div>
</body>
</html>

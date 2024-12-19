<?php
include("conexion.php");

if (isset($_POST['nombre_producto'], $_POST['descripcion'], $_POST['precio'], $_POST['cantidad_existencia'], $_POST['id_proveedor'])) {

    $nombre_producto = $_POST['nombre_producto'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $cantidad_existencia = $_POST['cantidad_existencia'];
    $id_proveedor = $_POST['id_proveedor'];

    
    $insertar = mysqli_query($con, "
        INSERT INTO productos (nombre_producto, descripcion, precio, cantidad_existencia, id_proveedor)
        VALUES ('$nombre_producto', '$descripcion', '$precio', '$cantidad_existencia', '$id_proveedor')
    ");

    if ($insertar) {
        $message = "Producto agregado correctamente.";
        $alert_class = "alert-success";
    } else {
        $message = "Error al agregar el producto. Intente nuevamente.";
        $alert_class = "alert-danger";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Agregar Producto</h1>


    <?php if (isset($message)): ?>
        <div class="alert <?php echo $alert_class; ?> alert-dismissible fade show" role="alert">
            <?php echo $message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>


    <form method="POST" action="agregar_producto.php">
        <div class="mb-3">
            <label class="form-label">Nombre del Producto</label>
            <input type="text" name="nombre_producto" class="form-control" placeholder="Ej. Laptop HP" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" placeholder="Ej. Laptop de 15 pulgadas, 8GB RAM..." rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Precio</label>
            <input type="number" name="precio" class="form-control" placeholder="Ej. 12000" step="0.01" min="0" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Cantidad en Stock</label>
            <input type="number" name="cantidad_existencia" class="form-control" placeholder="Ej. 10" min="1" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Proveedor</label>
            <select name="id_proveedor" class="form-select" required>
                <option value="" disabled selected>Seleccione un proveedor</option>
                <?php
 
                $proveedores = mysqli_query($con, "SELECT id_proveedor, nombre_empresa FROM proveedores");
                while ($row = mysqli_fetch_assoc($proveedores)) {
                    echo "<option value='{$row['id_proveedor']}'>{$row['nombre_empresa']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">Agregar Producto</button>
            <a href="mostrar_productos.php" class="btn btn-secondary">Regresar a Productos</a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


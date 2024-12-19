<?php
include("conexion.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contactar Proveedores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h1>Compra de productos</h1>
    <form method="POST" action="actualizar_stock.php">

        <div class="mb-3">
            <label class="form-label">Proveedor</label>
            <select name="proveedor" id="proveedor" class="form-select" required>
                <option value="" disabled selected>Seleccione un proveedor</option>
                <?php
                $proveedores = mysqli_query($con, "SELECT * FROM proveedores");
                while ($row = mysqli_fetch_assoc($proveedores)) {
                    echo "<option value='{$row['id_proveedor']}'>{$row['nombre_empresa']}</option>";
                }
                ?>
            </select>
        </div>

  
        <div class="mb-3">
            <label class="form-label">Producto</label>
            <select name="producto" id="producto" class="form-select" required>
                <option value="" disabled selected>Seleccione un producto</option>
   
            </select>
        </div>


        <div class="mb-3">
            <label class="form-label">Cantidad a Agregar</label>
            <input type="number" name="cantidad" class="form-control" min="1" required>
        </div>

        <div class="d-flex flex-wrap justify-content-center gap-2 mt-4">
        <a href="index.php" class="btn btn-primary btn-lg shadow-sm px-5 py-2">Regresar al inicio</a>
        <button type="submit" class="btn btn-primary btn-lg shadow-sm px-5 py-2">Actualizar Stock</button>
        </div>
    </form>
</div>


<script>
    $(document).ready(function() {
        $('#proveedor').change(function() {
            var proveedorID = $(this).val();

      
            $.ajax({
                url: 'obtener_productos.php',
                type: 'POST',
                data: { id_proveedor: proveedorID },
                success: function(data) {
                    $('#producto').html(data);
                }
            });
        });
    });
</script>
</body>
</html>


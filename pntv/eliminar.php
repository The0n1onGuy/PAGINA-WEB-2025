<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h1 class="mb-4">Eliminar Registro</h1>
    <form action="eliminar_producto.php" method="post">

        <div class="mb-3">
        <label class="form-label">Ingrese el ID del registro a eliminar:</label>
        <input type="number" class="form-control" name="id" required>
    </div>


        <div class="d-flex flex-wrap justify-content-center gap-2 mt-4">
        <button type="submit" class="btn btn-danger btn-lg shadow-sm px-5 py-2">Eliminar</button>
        <a href="mostrar_productos.php" class="btn btn-danger btn-lg shadow-sm px-5 py-2">Regresar</a>
        </div>
    </form>
    <br>

   

</body>
</html>


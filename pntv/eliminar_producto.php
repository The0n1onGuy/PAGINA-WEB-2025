<?php
include("conexion.php");

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);

    if ($id > 0) {
        // Consulta para eliminar el registro
        $query = "DELETE FROM productos WHERE id_producto = $id";
        $resultado = mysqli_query($con, $query);

        if ($resultado) {
            echo "Registro con ID $id eliminado exitosamente.";
        } else {
            echo "Error al eliminar el registro: " . mysqli_error($con);
        }
    } else {
        echo "ID no válido.";
    }
} else {
    echo "No se proporcionó ningún ID.";
}

echo "<br><a href='eliminar.php'>Volver al formulario</a>";

mysqli_close($con);
?>
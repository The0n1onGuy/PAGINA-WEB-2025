<?php
include("conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'];

    $query = "DELETE FROM clientes WHERE id_cliente = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);

    if (mysqli_stmt_execute($stmt)) {
        echo "Registro eliminado exitosamente.";
        
    } else {
        echo "Error: " . mysqli_error($con);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
}
?>

<a href="mostrar_cliente.php" class="btn btn-secondary">Volver al menu</a>
<?php
include("conexion.php");
session_start(); 

if (
    isset($_POST['cliente']) &&
    isset($_POST['empleado']) &&
    isset($_POST['producto']) &&
    isset($_POST['cantidad'])
) {
    $id_cliente = $_POST['cliente'];
    $id_empleado = $_POST['empleado'];
    $id_producto = $_POST['producto'];
    $cantidad = (int)$_POST['cantidad'];

    if ($cantidad <= 0) {
        $_SESSION['alert_message'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            La cantidad debe ser mayor a 0.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
        header("Location: ventas.php");
        exit();
    }

  
    $query_producto = mysqli_query($con, "SELECT cantidad_existencia, precio FROM productos WHERE id_producto = '$id_producto'");
    $producto = mysqli_fetch_assoc($query_producto);

    if (!$producto) {
        $_SESSION['alert_message'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            Producto no encontrado.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
        header("Location: ventas.php");
        exit();
    }

    $stock_actual = $producto['cantidad_existencia'];
    $precio_unitario = $producto['precio'];

    if ($stock_actual < $cantidad) {
        $_SESSION['alert_message'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            No hay suficiente stock. Disponible: $stock_actual unidades.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
        header("Location: ventas.php");
        exit();
    }

  
    $total = $cantidad * $precio_unitario;
    $query_venta = mysqli_query($con, "
        INSERT INTO ventas (fecha_venta, cantidad, total, id_empleado, id_cliente, id_producto)
        VALUES (NOW(), '$cantidad', '$total', '$id_empleado', '$id_cliente', '$id_producto')
    ");

    if ($query_venta) {
        $nuevo_stock = $stock_actual - $cantidad;
        mysqli_query($con, "UPDATE productos SET cantidad_existencia = '$nuevo_stock' WHERE id_producto = '$id_producto'");

        $_SESSION['alert_message'] = "<div id='alertMessage' class='alert alert-success alert-dismissible fade show' role='alert'>
            Venta registrada con éxito. Total: $$total
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";

        if ($nuevo_stock <= 5) {
            $_SESSION['alert_message'] .= "<div id='alertMessage' class='alert alert-warning alert-dismissible fade show' role='alert'>
                El stock del producto es bajo (Stock: $nuevo_stock). Contacta con el proveedor.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
    } else {
        $_SESSION['alert_message'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            Error al registrar la venta. Intente nuevamente.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    }
} else {
    $_SESSION['alert_message'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        Todos los campos son obligatorios.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
}

header("Location: ventas.php");
exit();
?>

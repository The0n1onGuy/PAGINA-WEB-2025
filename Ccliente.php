<?php
session_start();

// Verificar si es admin
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Conexión a la base de datos
$conexion = new mysqli("fdb1030.awardspace.net", "4547916_websitedb", "l4ded1234", "4547916_websitedb");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener clientes
$sql = "SELECT username, housenum, debt, paydate FROM clients ORDER BY id ASC";
$resultado = $conexion->query($sql);

?>

<?php
$sql_deudores = "SELECT id, username, housenum, debt FROM clients WHERE debt > 0 ORDER BY username ASC";
$deudores = $conexion->query($sql_deudores);

if (isset($_POST['saldar'])) {
    $id_cliente = $_POST['cliente_id'];
    $monto_pago = floatval($_POST['monto_pago']);

    // Verificar deuda actual
    $sql_ver = "SELECT debt FROM clients WHERE id = ?";
    $stmt = $conexion->prepare($sql_ver);
    $stmt->bind_param("i", $id_cliente);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $cliente = $resultado->fetch_assoc();

    if ($cliente) {
        $deuda_actual = floatval($cliente['debt']);

            if ($monto_pago > $deuda_actual) {
                    echo "<script>alert('El monto no puede ser mayor a la deuda actual ($" . number_format($deuda_actual, 2) . ")'); window.location.href='Ccliente.php';</script>";
                    exit(); // <-- MUY IMPORTANTE para evitar que continúe ejecutando el HTML de abajo
            }
            else {
            $nueva_deuda = $deuda_actual - $monto_pago;

            // Actualizar en base de datos
            $sql_upd = "UPDATE clients SET debt = ? WHERE id = ?";
            $stmt_upd = $conexion->prepare($sql_upd);
            $stmt_upd->bind_param("di", $nueva_deuda, $id_cliente);

            if ($stmt_upd->execute()) {
                echo "<script>alert('Pago registrado correctamente. Nueva deuda: $" . number_format($nueva_deuda, 2) . "'); window.location.href='Ccliente.php';</script>";
                    exit();
            } else {
                echo "<script>alert('Error al registrar el pago');</script>";
            }

            $stmt_upd->close();
        }
    }

    $stmt->close();
}
if (isset($_POST['anadir_deuda'])) {
    $sql_update_all = "UPDATE clients SET debt = debt + 300";
    if ($conexion->query($sql_update_all) === TRUE) {
        echo "<script>alert('Se añadieron $300 de deuda a todos los clientes.'); window.location.href='Ccliente.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar las deudas');</script>";
    }
}

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clientes Registrados</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <a href="adminUI.php">Volver al menú</a>
    <h2>Listado de Clientes Registrados</h2>

    <?php if ($resultado->num_rows > 0): ?>
        <table>
            <tr>
                <th>Usuario</th>
                <th>Número de casa</th>
                <th>Deuda</th>
                <th>Fecha de pago</th>
            </tr>
            <?php while ($fila = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($fila['username']); ?></td>
                    <td><?php echo htmlspecialchars($fila['housenum']); ?></td>
                    <td>$<?php echo number_format($fila['debt'], 2); ?></td>
                    <td><?php echo htmlspecialchars($fila['paydate']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p style="text-align:center;">No hay clientes registrados.</p>
    <?php endif; ?>
    <h2>Saldar Deuda</h2>
<form method="post" style="display: flex; justify-content: center; align-items: center; gap: 20px; margin: 20px;">
    <select name="cliente_id" required style="padding: 10px; min-width: 250px;">
        <option value="">Seleccione un cliente...</option>
        <?php while ($cliente = $deudores->fetch_assoc()): ?>
            <option value="<?php echo $cliente['id']; ?>">
                <?php echo $cliente['username'] . " | Casa #" . $cliente['housenum'] . " | Deuda: $" . number_format($cliente['debt'], 2); ?>
            </option>
        <?php endwhile; ?>
    </select>
    <input type="number" name="monto_pago" step="0.01" min="0.01" placeholder="Monto a pagar" required style="padding: 10px; width: 150px;">

    <button type="submit" name="saldar" style="padding: 10px 20px; background-color: #388E3C; color: white; border: none; border-radius: 4px;">
        Saldar
    </button>
   
</form>
    <div class="contenedor-boton">
    <form method="post" style="display:inline;">
        <button type="submit" name="anadir_deuda" style="padding: 10px 20px; background-color: #A5D6A7; color: #1B5E20; border: none; border-radius: 6px;">
            Añadir $300 de deuda a todos
        </button>
    </form>
    
</div>

    
</body>
</html>

<?php
$conexion->close();
?>

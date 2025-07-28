<?php
session_start();
if ($_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
echo "<h1>Bienvenido administrador: " . $_SESSION['usuario'] . "</h1>";

$conexion = new mysqli("fdb1030.awardspace.net", "4547916_websitedb", "l4ded1234", "4547916_websitedb");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$sql = "SELECT username, housenum, debt, paydate FROM clients ORDER BY id ASC";
$resultado = $conexion->query($sql);

?>

<?php
$sql_deudores = "SELECT id, username, housenum, debt FROM clients WHERE debt > 0 ORDER BY username ASC";
$deudores = $conexion->query($sql_deudores);

if (isset($_POST['saldar'])) {
    $id_cliente = $_POST['cliente_id'];
    $monto_pago = floatval($_POST['monto_pago']);

    $sql_ver = "SELECT debt, username FROM clients WHERE id = ?";
    $stmt = $conexion->prepare($sql_ver);
    $stmt->bind_param("i", $id_cliente);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $cliente = $resultado->fetch_assoc();
    $stmt->close();

    if ($cliente) {
        $deuda_actual = floatval($cliente['debt']);
        $username_cliente = $cliente['username'];

        if ($monto_pago > $deuda_actual) {
            echo "<script>alert('El monto no puede ser mayor a la deuda actual ($" . number_format($deuda_actual, 2) . ")'); window.location.href='adminUI.php';</script>";
            exit();
        }

        $nueva_deuda = $deuda_actual - $monto_pago;
        $sql_upd = "UPDATE clients SET debt = ? WHERE id = ?";
        $stmt_upd = $conexion->prepare($sql_upd);
        $stmt_upd->bind_param("di", $nueva_deuda, $id_cliente);

        if ($stmt_upd->execute()) {
            echo "<script>alert('Pago registrado correctamente. Nueva deuda: $" . number_format($nueva_deuda, 2) . "'); window.location.href='adminUI.php';</script>";
        } else {
            echo "<script>alert('Error al registrar el pago');</script>";
        }

        $stmt_upd->close();
    }
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
    <style>
        body {
            background: linear-gradient(to right, #ffffff, #c7ffc9ff);
}

    </style>  
<head>
    <meta charset="UTF-8">
    <title>Inicio Estilo Microsoft</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">Onion and Skeli bois corporated</div>
            <ul class="nav-links">
                <h2>Registrar:</h2>
                <button class="boton-login" onclick="location.href='Radmin.php'">Administrador</button>
                <button class="boton-login" onclick="location.href='Rclient.php'">Cliente</button>
            </ul>
                <div class="acciones-nav">
                <button class="boton-login" onclick="location.href='logout.php'">Cerrar sesion</button>
            </div>
        </nav>
    </header>

        <a href="adminUI.php">Refrescar tabla</a>
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
<form method="post" style="display: flex; justify-content: center; align-items: center; gap: 20px; margin: 20px;">
    <select name="cliente_id" required style="padding: 10px; min-width: 300px;">
        <option value="">Seleccione un cliente...</option>
        <?php while ($cliente = $deudores->fetch_assoc()): ?>
            <option value="<?php echo $cliente['id']; ?>">
                <?php echo $cliente['username'] . " | Casa #" . $cliente['housenum'] . " | Deuda: $" . number_format($cliente['debt'], 2); ?>
            </option>
        <?php endwhile; ?>
    </select>
    <input type="number" name="monto_pago" step="0.01" min="0.01" placeholder="Monto a pagar" required style="padding: 10px; width: 200px;">

    <button type="submit" name="saldar" style="padding: 6px 12px; background-color: #388E3C; color: white; border: none; border-radius: 4px;">
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

<?php
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'cliente') {
    header("Location: login.php");
    exit();
}

$conexion = new mysqli("fdb1030.awardspace.net", "4547916_websitedb", "l4ded1234", "4547916_websitedb");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$usuario = $_SESSION['usuario'];

// Obtener cliente
$sql = "SELECT * FROM clients WHERE username = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$resultado = $stmt->get_result();
$cliente = $resultado->fetch_assoc();
$stmt->close();

// Obtener banco (si existe)
$cliente_id = $cliente['id'];
$sqlb = "SELECT * FROM Clientbank WHERE client_id = ?";
$stmtb = $conexion->prepare($sqlb);
$stmtb->bind_param("i", $cliente_id);
$stmtb->execute();
$resb = $stmtb->get_result();
$bank = $resb->fetch_assoc();
$stmtb->close();

if (isset($_POST['guardar_tarjeta'])) {
    $banknum = $_POST['banknum'];
    $cv = $_POST['cv'];
    $balance = 1000;

    if (!empty($banknum) && !empty($cv)) {
        $stmtb = $conexion->prepare("INSERT INTO Clientbank (client_id, banknum, cv, balance) VALUES (?, ?, ?, ?)");
        $stmtb->bind_param("issi", $cliente_id, $banknum, $cv, $balance);

        if ($stmtb->execute()) {
            echo "<script>alert('Tarjeta registrada exitosamente. Ya puedes realizar pagos.'); window.location.href='cliente_info.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error al guardar tarjeta');</script>";
        }

        $stmtb->close();
    }
}


if (isset($_POST['realizar_pago'])) {
    $monto_pago = floatval($_POST['monto_pago']);

    if ($monto_pago <= 0) {
        echo "<script>alert('Monto inválido.');</script>";
        exit;
    }

    $stmtb = $conexion->prepare("SELECT balance FROM Clientbank WHERE client_id = ?");
    $stmtb->bind_param("i", $cliente_id);
    $stmtb->execute();
    $resb = $stmtb->get_result();
    $bankinfo = $resb->fetch_assoc();
    $stmtb->close();

    if (!$bankinfo || $bankinfo['balance'] < $monto_pago) {
        echo "<script>alert('Fondos insuficientes.');</script>";
    } else {
        $stmt = $conexion->prepare("SELECT debt FROM clients WHERE id = ?");
        $stmt->bind_param("i", $cliente_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $cliente_pago = $res->fetch_assoc();
        $stmt->close();

        $deuda_actual = floatval($cliente_pago['debt']);
        if ($monto_pago > $deuda_actual) {
            echo "<script>alert('No puedes pagar más de tu deuda actual ($" . number_format($deuda_actual, 2) . ")');</script>";
        } else {
            $nueva_deuda = $deuda_actual - $monto_pago;
            $nuevo_saldo = $bankinfo['balance'] - $monto_pago;

            $upd1 = $conexion->prepare("UPDATE clients SET debt = ? WHERE id = ?");
            $upd1->bind_param("di", $nueva_deuda, $cliente_id);

            $upd2 = $conexion->prepare("UPDATE Clientbank SET balance = ? WHERE client_id = ?");
            $upd2->bind_param("di", $nuevo_saldo, $cliente_id);

            if ($upd1->execute() && $upd2->execute()) {
                echo "<script>alert('Pago realizado con éxito. Nueva deuda: $" . number_format($nueva_deuda, 2) . "'); window.location.href='cliente_info.php';</script>";
                exit();
            } else {
                echo "<script>alert('Error al procesar el pago');</script>";
            }

            $upd1->close();
            $upd2->close();
        }
    }
}

$conexion->close();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Información</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        body {
            background-color: #E8F5E9;
            font-family: Arial, sans-serif;
        }

        h2 {
            text-align: center;
            color: #1B5E20;
            margin-top: 40px;
        }

        table {
            margin: 30px auto;
            border-collapse: collapse;
            width: 80%;
            background-color: white;
            box-shadow: 0 0 10px #ccc;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #A5D6A7;
            color: #1B5E20;
        }

        td {
            background-color: #F1F8E9;
        }

        .contenedor-boton {
            text-align: center;
            margin-bottom: 30px;
        }

        .contenedor-boton a {
            text-decoration: none;
            background-color: #388E3C;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
        }
    </style>
</head>
<body>
    <h2>Mis Datos</h2>
        <div class="acciones-nav">
                <button class="boton-login" onclick="location.href='logout.php'">Cerrar sesion</button>
            </div>
    <?php if ($cliente): ?>
        <table>
            <tr><th>Usuario</th><td><?php echo htmlspecialchars($cliente['username']); ?></td></tr>
            <tr><th>Teléfono</th><td><?php echo htmlspecialchars($cliente['cellphone']); ?></td></tr>
            <tr><th>Email</th><td><?php echo htmlspecialchars($cliente['email']); ?></td></tr>
            <tr><th>Deuda</th><td>$<?php echo number_format($cliente['debt'], 2); ?></td></tr>
            <tr><th>Número de casa</th><td><?php echo htmlspecialchars($cliente['housenum']); ?></td></tr>
            <tr><th>Fecha de pago</th><td><?php echo htmlspecialchars($cliente['paydate']); ?></td></tr>
        </table>
        <?php if ($bank): ?>
        <form method="post" style="margin: 20px auto; text-align: center;">
            <input type="number" name="monto_pago" step="0.01" min="0.01" placeholder="Monto a pagar" style="padding: 10px; width: 200px;" required>
            <button type="submit" name="realizar_pago" style="padding: 10px 20px; background-color: #388E3C; color: white; border: none; border-radius: 4px;">Pagar</button>
        </form>
        <?php else: ?>
        <form method="post" style="text-align: center; margin-top: 30px;">
            <input type="text" name="banknum" placeholder="Número de tarjeta" required style="padding: 10px;"><br><br>
            <input type="text" name="cv" placeholder="CV" required style="padding: 10px;"><br><br>
            <button type="submit" name="guardar_tarjeta" style="padding: 10px 20px; background-color: #1976D2; color: white; border: none; border-radius: 4px;">Guardar tarjeta</button>
        </form>
        <?php endif; ?>
    <?php else: ?>
        <p style="text-align: center;">No se encontraron datos para este usuario.</p>
    <?php endif; ?>

</body>
</html>

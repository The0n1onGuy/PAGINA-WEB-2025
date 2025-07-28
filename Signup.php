<?php
$conexion = new mysqli("fdb1030.awardspace.net", "4547916_websitedb", "l4ded1234", "4547916_websitedb");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];
$userT = $_POST['user_type'];

if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{6,}$/', $password)) {
    echo "<script>alert('La contraseña debe tener al menos 6 caracteres, una mayúscula, una minúscula y un símbolo.'); window.location.href = 'Radmin.php';</script>";
    exit();
}

if ($userT == 'client') {
    $cellphone = $_POST['cellphone'];
    $email     = $_POST['email'];
    $housenum  = $_POST['housenum'];
    $fecha     = date("Y-m-d");

    // Opcionales
    $banknum = $_POST['banknum'] ?? null;
    $cv      = $_POST['cv'] ?? null;

    SignClient($conexion, $username, $password, $cellphone, $email, $housenum, $fecha, $banknum, $cv);
} else {
    SignAdmin($conexion, $username, $password);
}

function SignClient($conexion, $username, $password, $cellphone, $email, $housenum, $fecha, $banknum, $cv) {
    $sql = "SELECT username FROM user WHERE username = ? UNION SELECT username FROM clients WHERE username = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $stmt->store_result();

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Error en el formato del correo electrónico'); window.history.back();</script>";
        exit(); 
    }

    if ($stmt->num_rows > 0) {
        echo "<script>alert('Este usuario ya existe. Usa otro nombre de usuario.'); window.location.href = 'Radmin.php';</script>";
        exit();
    }

    $stmt->close();

    $campos = [
        'username' => $username,
        'cellphone' => $cellphone,
        'email'    => $email,
        'housenum' => $housenum
    ];

    foreach ($campos as $campo => $valor) {
        $campo_usuario = in_array($campo, ['email', 'cellphone', 'housenum']) ? 'username' : $campo;

        if (
            existe($conexion, 'clients', $campo, $valor) ||
            existe($conexion, 'user', $campo_usuario, $valor)
        ) {
            echo "<script>alert('Error 415: Conflicto de información'); window.history.back();</script>";
            exit();
        }
    }

    $stmt = $conexion->prepare("INSERT INTO clients (username, password, cellphone, email, housenum, paydate) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $username, $password, $cellphone, $email, $housenum, $fecha);

    if ($stmt->execute()) {
        $id_cliente = $stmt->insert_id;

        if (!empty($banknum) && !empty($cv)) {
            $balance = 1000;
            $stmtb = $conexion->prepare("INSERT INTO Clientbank (client_id, banknum, cv, balance) VALUES (?, ?, ?, ?)");
            $stmtb->bind_param("issi", $id_cliente, $banknum, $cv, $balance);
            $stmtb->execute();
            $stmtb->close();
        }

        echo "<script>alert('Cliente registrado con éxito'); window.location.href = 'adminUI.php';</script>";
    } else {
        echo "<script>alert('Error al insertar cliente'); window.history.back();</script>";
    }

    $stmt->close();
    $conexion->close();
}

function SignAdmin($conexion, $username, $password) {
    $sql = "SELECT username FROM user WHERE username = ? UNION SELECT username FROM clients WHERE username = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('Este usuario ya existe. Usa otro nombre de usuario.'); window.location.href = 'Radmin.php';</script>";
        exit();
    }

    $stmt->close();

    $sql_insert = "INSERT INTO user (username, password) VALUES (?, ?)";
    $stmt_insert = $conexion->prepare($sql_insert);
    $stmt_insert->bind_param("ss", $username, $password);

    if ($stmt_insert->execute()) {
        echo "<script>alert('Administrador registrado exitosamente'); window.location.href = 'adminUI.php';</script>";
    } else {
        echo "Error al registrar: " . $stmt_insert->error;
    }

    $stmt_insert->close();
    $conexion->close();
}

function existe($conexion, $tabla, $campo, $valor) {
    $sql = "SELECT id FROM `$tabla` WHERE `$campo` = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $valor);
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows > 0;
}
?>

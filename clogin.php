<?php
session_start();

$conexion = new mysqli("fdb1030.awardspace.net", "4547916_websitedb", "l4ded1234", "4547916_websitedb");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}


$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];

$sql_admin = "SELECT * FROM user WHERE username = ? AND password = ?";
$stmt = $conexion->prepare($sql_admin);
$stmt->bind_param("ss", $usuario, $contrasena);
$stmt->execute();
$result_admin = $stmt->get_result();

if ($result_admin->num_rows === 1) {
    $_SESSION['usuario'] = $usuario;
    $_SESSION['rol'] = "admin";
    header("Location: adminUI.php");
    exit();
}

$sql_client = "SELECT * FROM clients WHERE username = ? AND password = ?";
$stmt = $conexion->prepare($sql_client);
$stmt->bind_param("ss", $usuario, $contrasena);
$stmt->execute();
$result_client = $stmt->get_result();

if ($result_client->num_rows === 1) {
    $_SESSION['usuario'] = $usuario;
    $_SESSION['rol'] = "cliente";
    header("Location: clientUI.php");
    exit();
}

echo "<script>
alert('Usuario o contraseña incorrectos');
window.location.href = 'login.php';
</script>";
?>

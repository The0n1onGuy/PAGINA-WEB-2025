<?php
$conexion = new mysqli("fdb1030.awardspace.net", "4547916_websitedb", "l4ded1234", "4547916_websitedb");
$used_houses = [];

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$sql = "SELECT housenum FROM clients";
$result = $conexion->query($sql);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $used_houses[] = (int)$row['housenum'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Cliente</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="contenedor">
        <h2>Registro de Cliente</h2>
        <form method="post" action="Signup.php">
            <input type="hidden" name="user_type" value="client">
            <input type="text" name="username" placeholder="Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <input type="text" name="cellphone" placeholder="Teléfono" required>
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <select name="housenum" required>
                <option value="">Seleccionar número de casa...</option>
                <?php
                for ($i = 1; $i <= 50; $i++) {
                    if (!in_array($i, $used_houses)) {
                        echo "<option value='$i'>$i</option>";
                    }
                }
                ?>
            </select>
            <input type="text" name="banknum" placeholder="Número de tarjeta (opcional)">
            <input type="text" name="cv" placeholder="CV (opcional)">
            <button type="submit">Registrar cliente</button>
        </form>
        <a href="adminUI.php" class="boton-info">Volver al inicio</a>
    </div>
</body>
</html>

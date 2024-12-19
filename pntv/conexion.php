<?php
$servername = "192.168.9.229";
$username = "Jesus";
$password = ""; 
$dbname = "empresa";

$con = new mysqli($servername, $username, $password, $dbname);

if ($con->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
} 
$message = "Conexión exitosa a la base de datos!";
echo "
<div id='alertMessage' class='alert alert-success alert-dismissible fade show' role='alert'>
    $message
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>
<script>
    setTimeout(function () {
        let alertMessage = document.getElementById('alertMessage');
        if (alertMessage) {
            alertMessage.classList.remove('show'); 
            alertMessage.classList.add('fade'); 
        }
    }, 1500); 
</script>
";

?>

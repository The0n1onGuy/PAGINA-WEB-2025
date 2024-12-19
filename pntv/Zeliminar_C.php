<?php
include("conexion.php");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FORM TEST</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- The above 3 meta tags must come first in the head; any other head content must come after these tags -->

    <link href="css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <?php if (isset($message)): ?>
        <div class="alert <?php echo $alert_class; ?> alert-dismissible fade show" role="alert">
            <?php echo $message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <table class = "table table-hover">
        <tr>
            <th>ID</th>    
            <th>Nombre</th>    
            <th>Apellido</th>    
            <th>Telefono</th>
            <th>Email</th>        
            <th>Direccion</th>
        <tr>
        <?php
        $sql = mysqli_query($con,"SELECT * FROM clientes");
        if(mysqli_num_rows($sql) == 0){
            echo "<tr><td> NO HAY DATOS!</tr></td>";
        }else{
        while ($row = mysqli_fetch_array($sql)) {
            echo '

                <tr>
                    <td>'.$row['id_cliente'].'</td>
                    <td>'.$row['nombre'].'</td>
                    <td>'.$row['apellido'].'</td>
                    <td>'.$row['telefono'].'</td>
                    <td>'.$row['email'].'</td>
                    <td>'.$row['direccion'].'</td>
                    <td>
                        <form action = "Zeliminar2.php" method = "GET">                    
                        <input type="hidden" name="id" value="' . $row['id_cliente'] . '">
                        <button type="submit" name = "submit" class="btn btn-danger"> Eliminar
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-text-fill" viewBox="0 0 16 16">
                        <path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M5 4h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1m-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5M5 8h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1m0 2h3a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1"/>
                        </svg>
                      </button></td>
                    </form>
                </tr>';
            }
        }
        ?>
    </table>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
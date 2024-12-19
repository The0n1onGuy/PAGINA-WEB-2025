<?php
include("conexion.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Punto de ventas</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/html5shiv@3.7.3/dist/html5shiv.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/respond.js@1.4.2/dest/respond.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Ventas</h2>
        <table class="table table-hover">
        <thead class="thead-dark">
                <tr>
                    <th style="text-align: center;">Id_Venta</th>
                    <th style="text-align: center;">Fecha de venta</th>
                    <th style="text-align: center;">Cantidad</th>
                    <th style="text-align: center;">Total</th>
                </tr>
                </thead>
            <tbody>
                <?php
                $sql = mysqli_query($con, "SELECT * FROM ventas");
                if (mysqli_num_rows($sql) == 0) {
                    echo '<tr><td colspan="7" class="text-center">No hay datos disponibles.</td></tr>';
                } else {
                    while ($row = mysqli_fetch_array($sql)) {
                        echo '
                        <tr>
                            <td align="center">' . $row['id_venta'] . '</td>
                            <td align="center">' . $row['fecha_venta'] . '</td>
                            <td align="center">' . $row['cantidad'] . '</td>
                            <td align="center">' . $row['total'] . '</td>
                        </tr>';
                    }
                }
                ?>
            </tbody>
        </table>

        
    <div class="d-flex flex-wrap justify-content-center gap-2 mt-4">
    <a href="index.php" class="btn btn-primary btn-lg shadow-sm px-5 py-2">Regresar</a>
    <a href="registrar_ventas.php" class="btn btn-primary btn-lg shadow-sm px-5 py-2">Registrar Venta</a>
    <a href="zcancelarV.php" class="btn btn-primary btn-lg shadow-sm px-5 py-2">Cancelar venta</a>
    <a href="mostrar_Datventas.php" class="btn btn-primary btn-lg shadow-sm px-5 py-2">Mostrar datos de venta</a>
    </div>




    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
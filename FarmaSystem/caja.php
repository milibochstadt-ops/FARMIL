<?php
    session_start();

    if (!isset($_SESSION["id_usuario"])) {
        header("Location: login.php");
        exit();
    }

?>

<!DOCTYPE html>
<html lang="es">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Caja | FarmaSystem</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <link rel="stylesheet" href="css/diseño.css">
    
    </head>

    <body class="bg-light">

        <?php include("navbar.php"); ?>

        <div class="container mt-5">

            <h2 class="text-center mb-4">
                💰 Control de Caja
            </h2>

            <div class="row justify-content-center">

                <div class="col-md-5">

                    <div class="card shadow p-4">

                        <h4 class="text-center">
                            Apertura y Cierre de Caja
                        </h4>

                        <a href="abrir_caja.php" class="btn btn-success mt-3">
                            🟢 Abrir Caja
                        </a>

                        <a href="cerrar_caja.php" class="btn btn-danger mt-3">
                            🔴 Cerrar Caja
                        </a>

                    </div>

                </div>

            </div>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    </body>

</html>
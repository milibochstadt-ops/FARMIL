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

        <title>Abrir Caja | FarmaSystem</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <link rel="stylesheet" href="css/diseño.css">

    </head>

    <body class="bg-light">

        <?php include("navbar.php"); ?>

        <div class="container mt-5">

            <div class="card shadow p-4">

                <h2 class="text-center mb-4">
                    🟢 Apertura de Caja
                </h2>

                <form action="guardar_apertura.php" method="POST">

                    <label class="form-label">
                        Monto inicial
                    </label>

                    <input
                        type="number"
                        name="monto_inicial"
                        class="form-control"
                        required>

                    <h5 class="mt-4">
                        Cantidad de billetes
                    </h5>

                    <label>$10000</label>
                    <input type="number" name="b10000" class="form-control" value="0">

                    <label>$2000</label>
                    <input type="number" name="b2000" class="form-control" value="0">

                    <label>$1000</label>
                    <input type="number" name="b1000" class="form-control" value="0">

                    <label>$500</label>
                    <input type="number" name="b500" class="form-control" value="0">

                    <label>$200</label>
                    <input type="number" name="b200" class="form-control" value="0">

                    <label>$100</label>
                    <input type="number" name="b100" class="form-control" value="0">

                    <button class="btn btn-success mt-4 w-100">
                        Guardar apertura
                    </button>

                </form>

            </div>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    </body>

</html>
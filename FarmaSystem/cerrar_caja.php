<?php
    session_start();

    if (!isset($_SESSION["id_usuario"])) {
        header("Location: login.php");
        exit();
    }

    require_once("conexion.php");


    // Buscar caja abierta

    $resultado = $conn->query("
        SELECT * FROM apertura_caja 
        WHERE estado='ABIERTA'
        ORDER BY id_apertura DESC
        LIMIT 1
    ");


    $caja = $resultado->fetch_assoc();


    if (!$caja) {

        echo "
        <script>
        alert('No hay una caja abierta');
        window.location='caja.php';
        </script>
        ";

        exit();

    }

?>


<!DOCTYPE html>
<html lang="es">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Cerrar Caja | FarmaSystem</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <link rel="stylesheet" href="css/diseño.css">

    </head>

    <body class="bg-light">

        <?php include("navbar.php"); ?>

        <div class="container mt-5">

            <div class="card shadow p-4">

                <h2 class="text-center mb-4">
                    🔴 Cierre de Caja
                </h2>

                <form action="guardar_cierre.php" method="POST">

                    <input
                        type="hidden"
                        name="id_apertura"
                        value="<?php echo $caja['id_apertura']; ?>">

                    <label class="form-label">
                        Monto final
                    </label>

                    <input
                        type="number"
                        name="monto_final"
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

                    <button class="btn btn-danger mt-4 w-100">
                        Cerrar Caja
                    </button>

                </form>

            </div>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    </body>

</html>
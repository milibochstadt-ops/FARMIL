<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    session_start();
    require_once("conexion.php");

    if (!isset($_SESSION["id_usuario"])) {
        header("Location: login.php");
        exit();
    }

    $id_usuario = $_SESSION["id_usuario"];
    $nombre_usuario = $_SESSION["nombre"];

    // Obtener la última caja abierta
    $sqlCaja = "SELECT monto_inicial
                FROM apertura_caja
                WHERE estado = 'ABIERTA'
                ORDER BY id_apertura DESC
                LIMIT 1";

    $resultCaja = $conn->query($sqlCaja);

    $apertura = 0;

    if ($resultCaja->num_rows > 0) {
        $filaCaja = $resultCaja->fetch_assoc();
        $apertura = $filaCaja["monto_inicial"];
    }

    // Sumar todas las ventas
    $sqlVentas = "SELECT SUM(total) AS total_ventas FROM ventas";
    $resultVentas = $conn->query($sqlVentas);

    $totalVentas = 0;

    if ($resultVentas->num_rows > 0) {
        $filaVentas = $resultVentas->fetch_assoc();
        $totalVentas = $filaVentas["total_ventas"] ?? 0;
    }

    // Total de dinero en caja
    $cajaActual = $apertura + $totalVentas;


    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $id_medicamento = $_POST["id_medicamento"];
        $cantidad = $_POST["cantidad"];


        // Buscar precio y stock del medicamento
        $sql = "SELECT precio, stock FROM medicamentos WHERE id_medicamento = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_medicamento);
        $stmt->execute();

        $resultado = $stmt->get_result();

        $medicamento = $resultado->fetch_assoc();


        if ($medicamento) {

            $precio = $medicamento["precio"];
            $stock = $medicamento["stock"];


            if ($cantidad <= $stock) {


                // Calcular total
                $total = $precio * $cantidad;


                // Guardar venta
                $sqlVenta = "INSERT INTO ventas 
                (id_usuario, id_medicamento, cantidad, precio_unit, total, fecha_venta)
                VALUES (?, ?, ?, ?, ?, NOW())";


                $stmtVenta = $conn->prepare($sqlVenta);


                if (!$stmtVenta) {
                    die("Error en consulta de venta: " . $conn->error);
                }


                $stmtVenta->bind_param(
                    "iiidd",
                    $id_usuario,
                    $id_medicamento,
                    $cantidad,
                    $precio,
                    $total
                );


                $stmtVenta->execute();



                // Actualizar stock
                $nuevo_stock = $stock - $cantidad;


                $sqlStock = "UPDATE medicamentos 
                SET stock = ? 
                WHERE id_medicamento = ?";


                $stmtStock = $conn->prepare($sqlStock);


                $stmtStock->bind_param(
                    "ii",
                    $nuevo_stock,
                    $id_medicamento
                );


                $stmtStock->execute();


                echo "<script>
                        alert('Venta registrada correctamente');
                        window.location.href='index.php';
                    </script>";


            } else {

                echo "<script>alert('No hay suficiente stock');</script>";

            }


        }

    }

?>

<!DOCTYPE html>
<html lang="es">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Ventas - FarmaSystem</title>

        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Tu diseño -->
        <link rel="stylesheet" href="css/diseño.css">

    </head>

    <body>

        <?php include("navbar.php"); ?>

        <div class="container mt-4">

            <div class="row align-items-center mb-4">

                <div class="col-md-8">

                    <h2>🛒 Registro de Ventas</h2>

                    <p class="text-muted">
                        Vendedor:
                        <strong><?php echo $nombre_usuario; ?></strong>
                    </p>

                </div>

                <div class="col-md-4">

                    <div class="card text-center">

                        <div class="card-body">

                            <h5 class="text-success">
                                💰 Caja Actual
                            </h5>

                            <p>
                                Apertura:
                                <strong>
                                    $<?php echo number_format($apertura, 2, ',', '.'); ?>
                                </strong>
                            </p>

                            <p>
                                Ventas:
                                <strong>
                                    $<?php echo number_format($totalVentas, 2, ',', '.'); ?>
                                </strong>
                            </p>

                            <hr>

                            <h3 class="text-success">
                                $<?php echo number_format($cajaActual, 2, ',', '.'); ?>
                            </h3>

                        </div>

                    </div>

                </div>

            </div>

            <div class="card p-4">

                <form method="POST">

                    <div class="mb-3">

                        <label>Medicamento</label>

                        <select name="id_medicamento" class="form-control" required>

                            <option value="">
                                Seleccionar medicamento
                            </option>

                            <?php
                            $sql = "SELECT * FROM medicamentos";
                            $resultado = $conn->query($sql);

                            while ($medicamento = $resultado->fetch_assoc()) {
                            ?>
                                <option value="<?php echo $medicamento['id_medicamento']; ?>">
                                    <?php echo $medicamento['nombre']; ?>
                                </option>
                            <?php
                            }
                            ?>

                        </select>

                    </div>

                    <div class="mb-3">

                        <label>Cantidad</label>

                        <input
                            type="number"
                            name="cantidad"
                            class="form-control"
                            min="1"
                            required>

                    </div>

                    <button class="btn btn-success w-100 py-2">
                        🛒 Registrar Venta
                    </button>

                </form>

            </div>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        <script src="js/script.js"></script>

    </body>

</html>
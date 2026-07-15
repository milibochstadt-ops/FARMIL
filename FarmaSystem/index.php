<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit();
}

require_once("conexion.php");


// Cantidad de medicamentos
$resultado = $conn->query("SELECT COUNT(*) AS total FROM medicamentos");
$medicamentos = $resultado->fetch_assoc()["total"];


// Ventas realizadas
$resultado = $conn->query("SELECT COUNT(*) AS total FROM ventas");
$ventas = $resultado->fetch_assoc()["total"];


// Stock bajo
$resultado = $conn->query("SELECT COUNT(*) AS total FROM medicamentos WHERE stock < 5");
$stock = $resultado->fetch_assoc()["total"];


// Estado de la caja
$resultado = $conn->query("SELECT COUNT(*) AS total FROM apertura_caja WHERE estado='ABIERTA'");
$caja = $resultado->fetch_assoc()["total"];

?>

<!DOCTYPE html>
<html lang="es">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Inicio | FarmaMil</title>


        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


        <!-- Diseño propio -->
        <link rel="stylesheet" href="css/diseño.css">


        <!-- Iconos -->
        <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    </head>


    <body>


        <?php include("navbar.php"); ?>


        <div class="container mt-4">


            <div class="bienvenida">


                <h2>
                    Bienvenido, <?php echo $_SESSION["nombre"]; ?>
                </h2>


                <p>
                    Panel principal de administración de FarmaMil
                </p>


            </div>



            <div class="row g-4">


                <!-- Medicamentos -->
                <div class="col-md-3">

                    <div class="card text-center shadow tarjeta">

                        <div class="card-body">

                            <i class="bi bi-capsule-pill fs-1 text-success"></i>

                            <h5 class="mt-3">Medicamentos</h5>

                            <h2><?php echo $medicamentos; ?></h2>

                        </div>

                    </div>

                </div>



                <!-- Ventas -->
                <div class="col-md-3">

                    <div class="card text-center shadow tarjeta">

                        <div class="card-body">

                            <i class="bi bi-cart-check fs-1 text-primary"></i>

                            <h5 class="mt-3">Ventas</h5>

                            <h2><?php echo $ventas; ?></h2>

                        </div>

                    </div>

                </div>



                <!-- Stock Bajo -->
                <div class="col-md-3">

                    <div class="card text-center shadow tarjeta">

                        <div class="card-body">

                            <i class="bi bi-exclamation-triangle fs-1 text-danger"></i>

                            <h5 class="mt-3">Stock Bajo</h5>

                            <h2><?php echo $stock; ?></h2>

                        </div>

                    </div>

                </div>



                <!-- Caja -->
                <div class="col-md-3">

                    <div class="card text-center shadow tarjeta">

                        <div class="card-body">


                            <i class="bi bi-cash-stack fs-1 text-warning"></i>


                            <h5 class="mt-3">Caja</h5>


                            <h2><?php echo $caja; ?></h2>



                            <?php

                            if ($caja > 0) {

                                echo "<span class='badge bg-success fs-6'>ABIERTA</span>";

                            } else {

                                echo "<span class='badge bg-danger fs-6'>CERRADA</span>";

                            }

                            ?>


                        </div>

                    </div>

                </div>


            </div>


        </div>



        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    </body>

</html>
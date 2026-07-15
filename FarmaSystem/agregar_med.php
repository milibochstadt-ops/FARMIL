<?php
    session_start();

    if (!isset($_SESSION["id_usuario"])) {
        header("Location: login.php");
        exit();
    }

    require_once("conexion.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $nombre = $_POST["nombre"];
        $laboratorio = $_POST["laboratorio"];
        $categoria = $_POST["categoria"];
        $precio = $_POST["precio"];
        $stock = $_POST["stock"];
        $fecha_venc = $_POST["fecha_venc"];
        $descripcion = $_POST["descripcion"];

        $sql = "INSERT INTO medicamentos
        (nombre,laboratorio,categoria,precio,stock,fecha_venc,descripcion)
        VALUES (?,?,?,?,?,?,?)";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            "sssdiss",
            $nombre,
            $laboratorio,
            $categoria,
            $precio,
            $stock,
            $fecha_venc,
            $descripcion
        );

        if($stmt->execute()){
            header("Location: medicamentos.php");
            exit();
        }else{
            $error="Error al guardar el medicamento.";
        }
    }
?>

<!DOCTYPE html>
<html lang="es">

    <head>

        <meta charset="UTF-8">

        <title>Agregar Medicamento</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    </head>

    <body class="bg-light">

        <?php include("navbar.php"); ?>

        <div class="container mt-4">

            <div class="card shadow">

                <div class="card-header bg-success text-white">

                    <h3>Agregar Medicamento</h3>

                </div>

                <div class="card-body">

                    <?php
                    if (isset($error)) {
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                    ?>

                    <form method="POST">

                        <div class="mb-3">

                            <label>Nombre</label>

                            <input
                                type="text"
                                name="nombre"
                                class="form-control"
                                required>

                        </div>

                        <div class="mb-3">

                            <label>Laboratorio</label>

                            <input
                                type="text"
                                name="laboratorio"
                                class="form-control"
                                required>

                        </div>

                        <div class="mb-3">

                            <label>Categoría</label>

                            <select
                                name="categoria"
                                class="form-select">

                                <option>Analgésico</option>
                                <option>Antibiótico</option>
                                <option>Antiinflamatorio</option>
                                <option>Vitamina</option>
                                <option>Otro</option>

                            </select>

                        </div>

                        <div class="row">

                            <div class="col">

                                <label>Precio</label>

                                <input
                                    type="number"
                                    step="0.01"
                                    name="precio"
                                    class="form-control"
                                    required>

                            </div>

                            <div class="col">

                                <label>Stock</label>

                                <input
                                    type="number"
                                    name="stock"
                                    class="form-control"
                                    required>

                            </div>

                        </div>

                        <br>

                        <div class="mb-3">

                            <label>Fecha de vencimiento</label>

                            <input
                                type="date"
                                name="fecha_venc"
                                class="form-control"
                                required>

                        </div>

                        <div class="mb-3">

                            <label>Descripción</label>

                            <textarea
                                name="descripcion"
                                class="form-control"
                                rows="4"></textarea>

                        </div>

                        <button class="btn btn-success">
                            Guardar Medicamento
                        </button>

                        <a
                            href="medicamentos.php"
                            class="btn btn-secondary">
                            Volver
                        </a>

                    </form>

                </div>

            </div>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    </body>

</html>
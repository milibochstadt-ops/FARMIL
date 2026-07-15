<?php
    session_start();

    if (!isset($_SESSION["id_usuario"])) {
        header("Location: login.php");
        exit();
    }

    require_once("conexion.php");

    if (!isset($_GET["id"])) {
        header("Location: medicamentos.php");
        exit();
    }

    $id = (int)$_GET["id"];

    // Actualizar
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $nombre = $_POST["nombre"];
        $laboratorio = $_POST["laboratorio"];
        $categoria = $_POST["categoria"];
        $precio = $_POST["precio"];
        $stock = $_POST["stock"];
        $fecha_venc = $_POST["fecha_venc"];
        $descripcion = $_POST["descripcion"];

        $sql = "UPDATE medicamentos
                SET nombre=?,
                    laboratorio=?,
                    categoria=?,
                    precio=?,
                    stock=?,
                    fecha_venc=?,
                    descripcion=?
                WHERE id_medicamento=?";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            "sssdissi",
            $nombre,
            $laboratorio,
            $categoria,
            $precio,
            $stock,
            $fecha_venc,
            $descripcion,
            $id
        );

        if ($stmt->execute()) {
            header("Location: medicamentos.php");
            exit();
        } else {
            $error = "No se pudo actualizar.";
        }
    }

    // Buscar medicamento
    $sql = "SELECT * FROM medicamentos WHERE id_medicamento=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $med = $stmt->get_result()->fetch_assoc();

    if (!$med) {
        header("Location: medicamentos.php");
        exit();
    }
?>

<<!DOCTYPE html>
<html lang="es">

    <head>

        <meta charset="UTF-8">

        <title>Editar Medicamento</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    </head>

    <body class="bg-light">

        <?php include("navbar.php"); ?>

        <div class="container mt-4">

            <div class="card shadow">

                <div class="card-header bg-warning">

                    <h3>Editar Medicamento</h3>

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
                                value="<?php echo htmlspecialchars($med['nombre']); ?>"
                                required>

                        </div>

                        <div class="mb-3">

                            <label>Laboratorio</label>

                            <input
                                type="text"
                                name="laboratorio"
                                class="form-control"
                                value="<?php echo htmlspecialchars($med['laboratorio']); ?>"
                                required>

                        </div>

                        <div class="mb-3">

                            <label>Categoría</label>

                            <input
                                type="text"
                                name="categoria"
                                class="form-control"
                                value="<?php echo htmlspecialchars($med['categoria']); ?>"
                                required>

                        </div>

                        <div class="row">

                            <div class="col">

                                <label>Precio</label>

                                <input
                                    type="number"
                                    step="0.01"
                                    name="precio"
                                    class="form-control"
                                    value="<?php echo $med['precio']; ?>"
                                    required>

                            </div>

                            <div class="col">

                                <label>Stock</label>

                                <input
                                    type="number"
                                    name="stock"
                                    class="form-control"
                                    value="<?php echo $med['stock']; ?>"
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
                                value="<?php echo $med['fecha_venc']; ?>"
                                required>

                        </div>

                        <div class="mb-3">

                            <label>Descripción</label>

                            <textarea
                                name="descripcion"
                                class="form-control"
                                rows="4"><?php echo htmlspecialchars($med['descripcion']); ?></textarea>

                        </div>

                        <button class="btn btn-warning">
                            Actualizar
                        </button>

                        <a href="medicamentos.php" class="btn btn-secondary">
                            Cancelar
                        </a>

                    </form>

                </div>

            </div>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    </body>

</html>
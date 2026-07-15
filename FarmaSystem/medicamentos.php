<?php
    session_start();

    if (!isset($_SESSION["id_usuario"])) {
        header("Location: login.php");
        exit();
    }

    require_once("conexion.php");

    // Eliminar medicamento
    if (isset($_GET["eliminar"])) {

        $id = $_GET["eliminar"];

        $sql = "DELETE FROM medicamentos WHERE id_medicamento = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        header("Location: medicamentos.php");
        exit();
    }

    // Buscar
    $buscar = "";

    if(isset($_GET["buscar"])){
        $buscar = $_GET["buscar"];
    }

    $sql = "SELECT * FROM medicamentos
            WHERE nombre LIKE ?
            ORDER BY nombre";

    $stmt = $conn->prepare($sql);

    $texto = "%".$buscar."%";

    $stmt->bind_param("s",$texto);

    $stmt->execute();

    $resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">

    <head>

        <meta charset="UTF-8">

        <title>Medicamentos</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <link rel="stylesheet" href="css/diseño.css">

        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    </head>

    <body>

        <?php include("navbar.php"); ?>

        <div class="container mt-4">

            <div class="bienvenida d-flex justify-content-between align-items-center">

                <div>

                    <h2>💊 Gestión de Medicamentos</h2>

                    <p class="mb-0">
                        Administrá el stock y la información de todos los medicamentos.
                    </p>

                </div>

                <a href="agregar_med.php" class="btn btn-success">

                    <i class="bi bi-plus-circle"></i>

                    Nuevo medicamento

                </a>

            </div>

            <form class="mt-3 mb-3">

                <div class="input-group">

                    <input
                        type="text"
                        name="buscar"
                        class="form-control"
                        placeholder="🔍 Buscar por nombre..."
                        value="<?php echo $buscar; ?>">

                    <button class="btn btn-primary">
                        Buscar
                    </button>

                </div>

            </form>

            <table class="table table-hover align-middle shadow-sm">

                <thead class="table-success">

                    <tr>
                        <th>Nombre</th>
                        <th>Laboratorio</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Vencimiento</th>
                        <th>Acciones</th>
                    </tr>

                </thead>

                <tbody>

                    <?php while ($fila = $resultado->fetch_assoc()) { ?>

                        <tr>

                            <td><?php echo $fila["nombre"]; ?></td>

                            <td><?php echo $fila["laboratorio"]; ?></td>

                            <td><?php echo $fila["categoria"]; ?></td>

                            <td>$<?php echo number_format($fila["precio"], 2); ?></td>

                            <td>

                                <?php
                                if ($fila["stock"] < 5) {
                                    echo "<span class='badge bg-danger'>" . $fila["stock"] . "</span>";
                                } else {
                                    echo "<span class='badge bg-success'>" . $fila["stock"] . "</span>";
                                }
                                ?>

                            </td>

                            <td><?php echo $fila["fecha_venc"]; ?></td>

                            <td>

                                <a
                                    href="editar_med.php?id=<?php echo $fila["id_medicamento"]; ?>"
                                    class="btn btn-warning btn-sm">
                                    Editar
                                </a>

                                <a
                                    href="medicamentos.php?eliminar=<?php echo $fila["id_medicamento"]; ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('¿Eliminar medicamento?')">
                                    Eliminar
                                </a>

                            </td>

                        </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        <script src="js/script.js"></script>

    </body>

</html>
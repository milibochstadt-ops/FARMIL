<?php
    session_start();
    require_once("conexion.php");

    if (isset($_SESSION['id_usuario'])) {
        header("Location: index.php");
        exit();
    }

    $error = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $correo = trim($_POST["correo"]);
        $contrasena = trim($_POST["contrasena"]);

        $sql = "SELECT * FROM usuarios WHERE correo = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $correo);
        $stmt->execute();

        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {

            $usuario = $resultado->fetch_assoc();

            if ($contrasena == $usuario["contrasena"]) {

                $_SESSION["id_usuario"] = $usuario["id_usuario"];
                $_SESSION["nombre"] = $usuario["nombre"];
                $_SESSION["rol"] = $usuario["rol"];

                header("Location: index.php");
                exit();

            } else {
                $error = "Contraseña incorrecta";
            }

        } else {
            $error = "El usuario no existe";
        }

    }
?>

<!DOCTYPE html>
<html lang="es">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Login | Farmil</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <style>

            body{
                min-height:100vh;
                display:flex;
                align-items:center;
                justify-content:center;

                background-image:
                linear-gradient(
                    rgba(25,135,84,0.55),
                    rgba(25,135,84,0.55)
                ),
                url("Imagen/mi_fondo.jpg");

                background-size:cover;
                background-position:center;

                font-family:'Segoe UI', Arial, sans-serif;
            }


            .login-card{

                width:420px;
                background:white;

                border-radius:25px;

                padding:35px;

                box-shadow:0 15px 40px rgba(0,0,0,.25);

            }


            .logo{

                text-align:center;
                margin-bottom:25px;

            }


            .logo h1{

                color:#198754;
                font-size:45px;
                font-weight:800;
                margin:0;

            }


            .logo p{

                color:#777;
                margin-top:5px;

            }


            label{

                font-weight:600;
                color:#146c43;

            }


            .form-control{

                border-radius:12px;
                padding:12px;

            }


            .btn-ingresar{

                background:#198754;
                border:none;

                border-radius:15px;

                padding:12px;

                font-weight:bold;

                color:white;

                width:100%;

            }


            .btn-ingresar:hover{

                background:#146c43;

            }


        </style>

    </head>


    <body>


        <div class="login-card">


            <div class="logo">

                <h1>FARMIL</h1>

                <p>Sistema de gestión farmacéutica</p>

            </div>



            <?php if ($error != "") { ?>

                <div class="alert alert-danger">

                    <?php echo $error; ?>

                </div>

            <?php } ?>



            <form method="POST">


                <div class="mb-3">

                    <label>Correo</label>

                    <input
                    type="email"
                    name="correo"
                    class="form-control"
                    placeholder="Ingrese su correo"
                    required>

                </div>



                <div class="mb-3">

                    <label>Contraseña</label>

                    <input
                    type="password"
                    name="contrasena"
                    class="form-control"
                    placeholder="Ingrese su contraseña"
                    required>

                </div>



                <button class="btn-ingresar">

                    Ingresar

                </button>


            </form>


        </div>



        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        <script src="js/script.js"></script>

    </body>

</html>
<?php

    session_start();

    require_once("conexion.php");


    // Verificar usuario logueado
    if (!isset($_SESSION["id_usuario"])) {
        header("Location: login.php");
        exit();
    }


    // Datos del formulario

    $id_usuario = $_SESSION["id_usuario"];

    $monto_inicial = $_POST["monto_inicial"];

    $b10000 = $_POST["b10000"];
    $b2000 = $_POST["b2000"];
    $b1000 = $_POST["b1000"];
    $b500 = $_POST["b500"];
    $b200 = $_POST["b200"];
    $b100 = $_POST["b100"];


    // Guardar apertura

    $sql = "INSERT INTO apertura_caja
    (
    id_usuario,
    monto_inicial,
    b10000,
    b2000,
    b1000,
    b500,
    b200,
    b100,
    estado
    )

    VALUES
    (
    '$id_usuario',
    '$monto_inicial',
    '$b10000',
    '$b2000',
    '$b1000',
    '$b500',
    '$b200',
    '$b100',
    'ABIERTA'
    )";


    if ($conn->query($sql)) {


        echo "
        <script>
            alert('Caja abierta correctamente');
            window.location='index.php';
        </script>
        ";


    }else{


        echo "Error al abrir caja: " . $conn->error;


    }


?>
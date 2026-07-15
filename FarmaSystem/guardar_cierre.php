<?php

    session_start();

    require_once("conexion.php");


    if (!isset($_SESSION["id_usuario"])) {

        header("Location: login.php");
        exit();

    }


    // Datos recibidos

    $id_apertura = $_POST["id_apertura"];

    $monto_final = $_POST["monto_final"];

    $b10000 = $_POST["b10000"];
    $b2000 = $_POST["b2000"];
    $b1000 = $_POST["b1000"];
    $b500 = $_POST["b500"];
    $b200 = $_POST["b200"];
    $b100 = $_POST["b100"];




    // Guardar cierre

    $sql = "INSERT INTO cierre_caja
    (
    id_apertura,
    monto_final,
    b10000,
    b2000,
    b1000,
    b500,
    b200,
    b100
    )

    VALUES
    (
    '$id_apertura',
    '$monto_final',
    '$b10000',
    '$b2000',
    '$b1000',
    '$b500',
    '$b200',
    '$b100'
    )";



    if ($conn->query($sql)) {


        // Cambiar estado de caja

        $conn->query("
            UPDATE apertura_caja 
            SET estado='CERRADA'
            WHERE id_apertura='$id_apertura'
        ");



        echo "

        <script>

        alert('Caja cerrada correctamente');

        window.location='generar_pdf.php';

        </script>

        ";



    }else{


        echo "Error al cerrar caja: " . $conn->error;


    }


?>
<?php

$host = "sql305.infinityfree.com";
$usuario = "if0_42165692";
$password = "FxzcxAo3fgPB";
$basedatos = "if0_42165692_farmacia";

$conn = new mysqli($host, $usuario, $password, $basedatos);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>
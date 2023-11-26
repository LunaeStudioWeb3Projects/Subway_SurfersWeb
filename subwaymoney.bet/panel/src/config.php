<?php

$host = "186.227.202.72";
$usuario = "fruitsm1_subwayuser";
$senhaDB = "lambaridesaldomar";
$banco = "fruitsm1_subway";

// Check if a connection is already established
if (!isset($conexao) || !($conexao instanceof mysqli) || $conexao->connect_error) {
    // Create a new database connection
    $conexao = new mysqli($host, $usuario, $senhaDB, $banco);

    // Check for connection errors
    if ($conexao->connect_error) {
        die("Erro na conexão: " . $conexao->connect_error);
    }
}
?>
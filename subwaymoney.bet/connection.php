<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); // Inicia a sessão

require('config.php');

$conn = new mysqli($host, $usuario, $senhaDB, $banco);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verifica se a variável de sessão está definida
if (isset($_SESSION["id_usuario"])) {
    $userId = $_SESSION["id_usuario"];

    // Usando declarações preparadas para prevenir SQL Injection
    $stmt = $conn->prepare("SELECT demo_balance FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId); // 'i' indica que o parâmetro é um inteiro
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row['demo_balance'];
    } else {
        echo "User not found";
    }

    $stmt->close();
} else {
    echo "ID do usuário não definido na sessão";
}

$conn->close();
?>

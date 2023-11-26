<?php
require('config.php');
$conn = new mysqli($host, $usuario, $senhaDB, $banco);

// Checar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

session_start(); // Inicia a sessão PHP

// Verifica se a variável de sessão existe
if(isset($_SESSION['id_usuario'])) {
    $idUsuario = $_SESSION['id_usuario'];

    // Preparar e executar a consulta
    $sql = "SELECT * FROM users WHERE id = ? AND isAfiliado = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idUsuario); // 'i' significa que o parâmetro é um inteiro
    $stmt->execute();

    $result = $stmt->get_result();

    // Verificar se a consulta encontrou um registro
    if ($result->num_rows > 0) {
        echo "1"; // Envia "1" se o usuário tem idAfiliado = 1
    } else {
        echo "0"; // Envia "0" se não encontrar nenhum usuário com idAfiliado = 1
    }

    $stmt->close();
} else {
    echo "Usuário não logado";
}

$conn->close();
?>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recuperar dados do formulário
    $email = $_POST["email"];
    $senha = $_POST["password"];

    require_once("config.php"); // Inclua o arquivo de configuração

    
    $conn = new mysqli($host, $usuario, $senhaDB, $banco);
    if ($conexao->connect_error) {
        die("Erro na conexão: " . $conexao->connect_error);
    }

    // Escapar os valores para prevenir injeção de SQL
    $email = $conexao->real_escape_string($email);
    $senha = $conexao->real_escape_string($senha);

    // Consultar o banco de dados para verificar as credenciais do usuário
    $sql = "SELECT id FROM users WHERE email = '$email' AND password = '$senha'";
    $resultado = $conexao->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        // Usuário autenticado com sucesso
        session_start();
        $row = $resultado->fetch_assoc();
        $_SESSION["id_usuario"] = $row["id"];
        
        // Atualizar o campo status_online para 1
        $idUsuario = $row["id"];
        $sqlUpdate = "UPDATE users SET status_online = 1 WHERE id = $idUsuario";
        $conexao->query($sqlUpdate);
        
        $conexao->close();
        header("Location: game"); // Redirecionar para a página principal
        exit();
    } else {
        // Credenciais inválidas
        echo "<script>alert('Credenciais inválidas.'); window.location.href='connect';</script>";
    }

    $conexao->close();
}
?>

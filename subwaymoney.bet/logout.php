<?php
session_start();

// Verificar se o usuário está logado
if (isset($_SESSION["id_usuario"])) {
    // Conectar ao banco de dados
     require_once("config.php"); // Inclua o arquivo de configuração

    
    $conexao = new mysqli($host, $usuario, $senhaDB, $banco);
    if ($conexao->connect_error) {
        die("Erro na conexão: " . $conexao->connect_error);
    }
    
    $idUsuario = $_SESSION["id_usuario"];
    
    // Atualizar o campo status_online para 0
    $sqlUpdate = "UPDATE users SET status_online = 0 WHERE id = $idUsuario";
    $conexao->query($sqlUpdate);
    
    $conexao->close();
}

// Encerrar a sessão
session_destroy();

// Redirecionar para a página principal após o logout
header("Location: index.php");
exit();
?>

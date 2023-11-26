<?php
// Conecte-se ao banco de dados (substitua as informações de conexão pelo seu próprio)
require_once('config.php');

$conn = new mysqli($host , $usuario , $senhaDB , $banco);

// Verifique a conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Recupere o ID do usuário da sessão
session_start();
$idUsuario = $_SESSION["id_usuario"];

// Atualize a coluna video_view para 1 no banco de dados para o usuário com base no ID da sessão
$sql = "UPDATE users SET video_view = 1 WHERE id = $idUsuario";
$updateSql = "UPDATE users SET tentativas = 1 WHERE id = $idUsuario"; 



if ($conn->query($sql) === TRUE) {
    echo "Coluna video_view atualizada com sucesso";
} else {
    echo "Erro ao atualizar a coluna video_view: " . $conn->error;
}

if ($conn->query($updateSql) === TRUE) {
    echo "Coluna video_view atualizada com sucesso";
} else {
    echo "Erro ao atualizar a coluna video_view: " . $conn->error;
}

// Feche a conexão com o banco de dados
$conn->close();
?>

<?php
// Iniciar a sessão
session_start();

// Verificar se o usuário está autenticado
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    // Usuário não autenticado, redirecionar para a página de login
    header("Location: src/html/index.php");
    exit();
}
?>

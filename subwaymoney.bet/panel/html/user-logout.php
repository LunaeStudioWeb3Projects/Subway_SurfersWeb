<?php
// Iniciar ou retomar a sessão
session_start();

// Destruir todos os dados registrados na sessão
session_destroy();

// Redirecionar para a página de login
header("Location: ../../index.php");
exit();
?>

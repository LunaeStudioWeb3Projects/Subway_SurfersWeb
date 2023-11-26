<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
<script>
    // Verifica se há um parâmetro "email_sent" na URL
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has("email_sent")) {
        // Exibe um alerta
        alert("Um e-mail com a nova senha foi enviado para o seu endereço de e-mail.");
        
        // Redireciona para a página inicial (index) após o usuário clicar em "OK"
        window.location.href = "index"; // Substitua "index.php" pelo caminho correto da sua página inicial
    }
</script>
    <!-- Conteúdo da página -->
</body>
</html>

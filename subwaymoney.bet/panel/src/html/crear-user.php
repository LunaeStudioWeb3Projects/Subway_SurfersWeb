                        
<?php
// Conexão com o banco de dados (substitua as credenciais conforme necessário)


require('../config.php');

$conn = new mysqli($host, $usuario, $senhaDB, $banco);

// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Processar o formulário quando o botão é clicado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar os dados do formulário
    $nameUser = $_POST["name_user"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $saldoValue = $_POST["saldoValue"];
    $isAfiliado = 1;

    // Inserir os dados na tabela users
    $insertSql = "INSERT INTO users (name, email, password, demo_balance, isAfiliado) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertSql);
    $stmt->bind_param("sssis", $nameUser, $email, $password, $saldoValue, $isAfiliado);

    // Verificar se a inserção foi bem-sucedida
    if ($stmt->execute()) {
        echo '<script>alert("Usuário criado com sucesso!"); window.location.href = "create-user.php";</script>';
    } else {
        echo '<script>alert("Erro ao criar usuário: ' . $conn->error . '");</script>';
    }

    // Fechar a instrução preparada
    $stmt->close();
}

// Fechar a conexão com o banco de dados
$conn->close();
?>
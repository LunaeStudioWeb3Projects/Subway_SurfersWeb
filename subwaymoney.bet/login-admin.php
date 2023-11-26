<?php
// Configurações do banco de dados
require_once("config.php"); // Inclua o arquivo de configuração



// Dados do formulário de login
$userInput = $_POST['userName'];
$passInput = $_POST['password'];

// Criar uma conexão com o banco de dados
    $conn = new mysqli($host, $usuario, $senhaDB, $banco);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Consulta utilizando prepared statement para verificar as credenciais
$sql = "SELECT id FROM admin_master WHERE username = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $userInput, $passInput);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Credenciais corretas
    echo "<script>alert('Login bem-sucedido!');</script>";    // Aqui você pode redirecionar o usuário para a página do painel de administração
    // Autenticação bem-sucedida

    // Iniciar uma sessão
    session_start();

    // Definir um marcador de autenticação na sessão
    $_SESSION['authenticated'] = true;

    // Redirecionar para a página da dashboard
    header("Location: dashboard/html/index.php");
    exit();

} else {
    // Credenciais incorretas
    echo "<script>alert('Login falhou. Verifique suas credenciais.');</script>";}
    header("Location: index.php");
    exit();

$stmt->close();



$conn->close();
?>

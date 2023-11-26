<?php
// Conexão com o banco de dados (substitua as credenciais conforme necessário)
$servername = "162.240.155.184";
$username = "wwfrui_root";
$password = "Ru@nhenrique123";
$dbname = "wwfrui_users";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verifica se a solicitação POST contém o ID da solicitação
if (isset($_POST['idSolicitacao'])) {
    $idSolicitacao = $_POST['idSolicitacao'];

    // Atualiza o status no banco de dados
    $updateSql = "UPDATE solicitacoes_de_saque SET status = 'PAGO' WHERE ID = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("i", $idSolicitacao);

    if ($stmt->execute()) {
        echo "Pagamento bem-sucedido!";
    } else {
        echo "Erro ao pagar o saque: " . $conn->error;
    }

    // Fechar a instrução preparada
    $stmt->close();
} else {
    echo "ID da solicitação não fornecido.";
}

// Fechar a conexão com o banco de dados
$conn->close();
?>

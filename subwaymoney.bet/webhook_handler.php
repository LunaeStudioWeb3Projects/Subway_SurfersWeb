<?php
require('config.php');

// Verifique se a solicitação é um POST válido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    // Capturar o corpo da solicitação
    $requestData = file_get_contents('php://input');
    $json = json_decode($requestData, true);
    $transaction_id = $json['transaction_id'];
    $status = $json['status'];

    if ($status == 1) {
        $sql = "UPDATE unprocessed_deposits SET paid=$status WHERE transaction_id = $transaction_id";
        $resultado = $conexao->query($sql);
    }
    
    header('Location: deposit');
} else {
    // Responda a outras solicitações, se necessário
    http_response_code(405); // Método não permitido
    echo "Método não permitido";
}
?>

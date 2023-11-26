<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);



require_once("config.php");

session_start();

require_once('vendor/autoload.php');

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

$client = new \GuzzleHttp\Client(['verify' => false,]);

$idUsuario = $_SESSION["id_usuario"];

function enviarEmailDeBoasVindas($nome, $email) {

    $emailSG = new \SendGrid\Mail\Mail(); 
    $emailSG->setFrom("contato@subwaymoney.bet", "Subway Money");
    $emailSG->setTemplateId('d-0c1d634b29ed491d9c58c97b7e5836e3');
    $emailSG->setSubject("Bem-vindo ao Subway Money!");
    $emailSG->addTo($email, $nome);
    $emailSG->addContent("text/plain", "Olá $nome, código Pix Gerado com sucesso!!");
    $emailSG->addContent(
        "text/html", "<strong>Olá $nome,</strong><br>Bem-vindo ao Subway Money!"
    );

    $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));

    try {
        $response = $sendgrid->send($emailSG);
        // Você pode querer logar essa resposta
    } catch (Exception $e) {
        // Logar a exceção para depuração
        error_log('Erro ao enviar e-mail: ' . $e->getMessage());
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cpfDeposito = $_POST['depositCPF'];
    $_SESSION['cpf'] = $cpfDeposito;
    $_SESSION['valorDeposito'] = $_POST['depositAmount'];
    $data = $_POST['data'];
    $valorDeposito = $_SESSION['valorDeposito'];

    $conn = new mysqli($host, $usuario, $senhaDB, $banco);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
     // Verifica se o CPF é válido
    if (strlen($cpfDeposito) !== 11) {
        echo "<script>alert('CPF inválido. Tente novamente!'); window.history.back();</script>";
        exit();
    }
    

    $sql = "SELECT name, email FROM users WHERE id = $idUsuario";
    $resultado = $conn->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $nome = $_POST['nameUser'];
        $email = $row['email'];

    } else {
        exit();
    }

    // Generate a unique transaction ID
    $transaction_id = generateUniqueTransactionID($conn);

    if (empty($transaction_id)) {
        // Handle the case where a unique ID couldn't be generated
        echo "Error: Unable to generate a unique transaction ID.";
        exit();
    }

    // Insert the unique transaction ID into the database
    $sql = "INSERT INTO unprocessed_deposits (transaction_id, amount, due, name, document_number) VALUES ('$transaction_id', $valorDeposito, '$data', '$nome', '$cpfDeposito')";
    $resultado = $conn->query($sql);

    if (strlen($cpfDeposito) !== 11) {
        echo '<script>';
        echo 'alert("CPF inválido. Tente novamente!");';
        echo 'window.history.back();';
        echo '</script>';
        exit();
    }

    // Create the payment request
    $headers = [
        'Authorization' => '1D1C72C79CE86F31A71F41431D3484B6DAB60FAABB0DC3D78183F80F18A9489C',
        'Content-Type' => 'application/json'
    ];
    $body = [
        "transaction_id" => "$transaction_id",
        "currency" => "BRL",
        "amount" => $valorDeposito,
        "due" => "$data",
        "name" => "$nome",
        "document_type" => "CPF",
        "document_number" => "$cpfDeposito",
        "webhook" => "https://subwaymoney.bet/webhook_handler.php",
    ];
    $request = new Request('POST', 'https://api.ipague.com.br/v2/pix', $headers, json_encode($body));
    $res = $client->sendAsync($request)->wait();

    $httpStatus = $res->getStatusCode();

    if ($httpStatus == 200) {
        // Process the response data
        $data = $res->getBody()->getContents();
        $json = json_decode($data, true);

        if (isset($json['qrcode'])) {
            // The response contains the ID, so the process was successful
            $pixCopiaCola = $json['qrcode'];
            $transaction_id = $json['transaction_id'];

            $_SESSION['pix'] = $pixCopiaCola;
            $_SESSION['transaction_id'] = $transaction_id;
            $conn->close();
            header("Location: deposit.php");
        } else {
            echo "Invalid API response: " . $res;
        }
    } else {
        echo "Request error: HTTP status code $httpStatus";
    }
    enviarEmailDeBoasVindas($nome, $email);

    $conn->close();
}

function generateUniqueTransactionID($conn)
{
    // Maximum number of attempts to generate a unique transaction ID
    $max_attempts = 5;
    $attempts = 0;

    while ($attempts < $max_attempts) {
        // Generate a random 15-digit transaction ID
        $transaction_id = mt_rand(100000000000000, 999999999999999);

        // Check if the transaction ID already exists in the database
        $sql_check = "SELECT COUNT(*) FROM unprocessed_deposits WHERE transaction_id = '$transaction_id'";
        $result_check = $conn->query($sql_check);

        if ($result_check && $result_check->fetch_row()[0] == 0) {
            // The generated ID doesn't exist, it's unique
            return $transaction_id;
        }

        $attempts++;
    }

    return null; // Couldn't generate a unique ID after max attempts
}

?>

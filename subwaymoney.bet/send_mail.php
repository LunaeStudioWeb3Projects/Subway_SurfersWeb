<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    require 'vendor/autoload.php'; 

function enviarEmailDeBoasVindas($nome, $email) {

    $emailSG = new \SendGrid\Mail\Mail(); 
    $emailSG->setFrom("contato@subwaymoney.bet", "Subway Money");
    $emailSG->setTemplateId('d-35b09c23b74f4c29a647e04851975e8b');
    $emailSG->setSubject("Bem-vindo ao Subway Money!");
    $emailSG->addTo($email, $nome);
    $emailSG->addContent("text/plain", "Olá $nome, bem-vindo ao Subway Money!");
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
?>

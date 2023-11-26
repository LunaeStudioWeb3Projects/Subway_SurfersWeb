<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

ob_start();

require 'vendor/autoload.php'; 
require("config.php"); // Inclua o arquivo de configuração


$conexao = new mysqli($host, $usuario, $senhaDB, $banco);
if ($conexao->connect_error) {
    die("Erro na conexão: " . $conexao->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupere o endereço de e-mail fornecido pelo usuário
    $email = $_POST["email"];

    // Verifique se o e-mail está associado a uma conta de usuário
    if (verificarEmail($conexao, $email)) {
        // Gere um token de redefinição de senha
        $token = gerarToken();

        // Salve o token como a nova senha no banco de dados
        salvarTokenNoBancoDeDados($conexao, $email, $token);

        // Envie um e-mail com a nova senha
        enviarEmailRedefinicaoSenha($email, $token);

        // Redirecione o usuário para uma página de confirmação
        header("Location: confirmacao.php?email_sent=1");
        exit();
    } else {
        // Se o e-mail não estiver associado a uma conta, mostre uma mensagem de erro
        echo "O endereço de e-mail não está registrado.";
    }
}

function gerarToken() {
    // Gere um valor aleatório (pode ser uma string alfanumérica)
    $token = bin2hex(random_bytes(5)); // Gera um token de 10 caracteres

    return $token;
}


function verificarEmail($conexao, $email) {
    // Consulte seu banco de dados para verificar se o e-mail existe na tabela de contas de usuário
    $email = $conexao->real_escape_string($email); // Evita SQL Injection
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conexao->query($sql);

    if ($result->num_rows > 0) {
        return true; // O e-mail existe
    } else {
        return false; // O e-mail não existe
    }
}

function salvarTokenNoBancoDeDados($conexao, $email, $token) {
    // Atualize a senha do usuário com o token no banco de dados
    $email = $conexao->real_escape_string($email); // Evita SQL Injection
    $token = $conexao->real_escape_string($token);

    $sql = "UPDATE users SET password = '$token' WHERE email = '$email'";
    $conexao->query($sql);
}

function enviarEmailRedefinicaoSenha($email, $token) {
    $emailSG = new \SendGrid\Mail\Mail(); 
    $emailSG->setFrom("contato@subwaymoney.bet", "Subway Money");
    $emailSG->setSubject("Recuperação de Senha");
    $emailSG->addTo($email);

    // Conteúdo do e-mail
    $emailSG->addContent("text/plain", "Olá,\n\nVocê solicitou a redefinição de senha. Sua nova senha é: $token\n\nPor favor, acesse a página de login e faça a alteração de senha após fazer o login.\n\nAtenciosamente,\nSua equipe de suporte");

    $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));

    try {
        $response = $sendgrid->send($emailSG);
        echo "E-mail de recuperação de senha enviado com sucesso.";
    } catch (Exception $e) {
        echo "Erro ao enviar o e-mail de recuperação de senha: " . $e->getMessage();
    }
}
?>

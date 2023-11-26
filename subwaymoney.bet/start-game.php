<?php
session_start(); // Iniciar a sessão (caso ainda não tenha sido iniciada)

// Verificar se o usuário está autenticado (exemplo)
if (!isset($_SESSION["id_usuario"])) {
    $idUsuario = $_SESSION["id_usuario"];
    header("Location: connect"); // Redirecionar para a página de login
    exit();
}

// Conectar ao banco de dados (substitua pelos seus dados)
require_once("config.php");

$conexao = new mysqli($host, $usuario, $senhaDB, $banco);
if ($conexao->connect_error) {
    die("Erro na conexão: " . $conexao->connect_error);
}

// Recuperar o ID do usuário da sessão
$idUsuario = $_SESSION["id_usuario"];

// Recuperar o valor de entrada do campo de entrada "aposta"
$valorEntrada = $_POST["aposta"];

// Calcular o valor da META como o dobro do valor de entrada
$meta = $valorEntrada * 2;

 // Consultar o banco de dados para obter o valor de status_online
    $sql = "SELECT total_movimentado FROM users WHERE id = $idUsuario";
    $resultado = $conexao->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $total_movimentado = $row["total_movimentado"];
    } 
    

// Consultar o banco de dados para obter o valor de demo_balance
$sql = "SELECT demo_balance FROM users WHERE id = $idUsuario";
$resultado = $conexao->query($sql);

if ($resultado && $resultado->num_rows > 0) {
    $row = $resultado->fetch_assoc();
    $demoBalance = $row["demo_balance"];

    // Definir valor mínimo
    $valorMinimo = 1; // Altere para o valor mínimo desejado

    if ($valorEntrada >= $valorMinimo && $demoBalance >= $valorEntrada) {
        // Reduzir o valor de entrada do demo_balance
        $novoDemoBalance = $demoBalance - $valorEntrada;
        $novoTotal_Movimentado = $total_movimentado + $valorEntrada;
        
        // Atualizar o demo_balance no banco de dados
        $sql = "UPDATE users SET total_movimentado = $novoTotal_Movimentado WHERE id = $idUsuario";
        if ($conexao->query($sql) === TRUE) {
           
            
        } else {
            echo "Erro ao atualizar o total_movimentado: " . $conexao->error;
        }

        // Atualizar o demo_balance no banco de dados
        $sql = "UPDATE users SET demo_balance = $novoDemoBalance WHERE id = $idUsuario";
        if ($conexao->query($sql) === TRUE) {
            // Redirecionar para o jogo com aposta e meta na URL
header("Location: real-game/index.php?id_usuario=" . urlencode($idUsuario) . "&aposta=" . urlencode($valorEntrada) . "&meta=" . urlencode($meta));

            exit();
        } else {
            echo "Erro ao atualizar o demo_balance: " . $conexao->error;
        }
    } else {
        // Exibir alerta de saldo insuficiente e reiniciar a página
        echo '<script>alert("Saldo insuficiente. Por favor, recarregue sua conta."); window.location.href = "deposit";</script>';
    }
} else {
    echo "Erro ao obter o demo_balance do banco de dados.";
}



$conexao->close();
?>

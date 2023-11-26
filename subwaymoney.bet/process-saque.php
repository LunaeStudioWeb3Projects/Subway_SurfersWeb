<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Verificar se o usuário está autenticado
if (!isset($_SESSION["id_usuario"])) {
    header("Location: connect");
    exit();
}

// Recuperar o valor da variável de sessão
if (isset($_SESSION['idUsuario'])) {
    $idUsuarioRecuperado = $_SESSION['idUsuario'];
} else {
    header("Location: connect");
    exit();
}

// Verifique se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexão com o banco de dados (substitua pelos detalhes de conexão reais)

    require("config.php"); // Inclua o arquivo de configuração

    // Criar uma conexão
    $conn = new mysqli($host, $usuario, $senhaDB, $banco);

    // Verificar a conexão
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Dados do formulário
    $nomeDestinatario = $_POST["withdrawName"];
    $valorSaque = $_POST["withdrawValue"];
    $chavePIX = $_POST["withdrawCPF"];
    
      // Preparar a consulta para recuperar o saldo disponível
    $totalQuery = "SELECT total_depositado FROM users WHERE id = ?";
    $totalStmt = $conn->prepare($totalQuery);
    $totalStmt->bind_param("i", $idUsuarioRecuperado);
    $totalStmt->execute();
    $totalResult = $totalStmt->get_result();
    
    if ($totalResult->num_rows > 0) {
        $row = $totalResult->fetch_assoc();
        $totalDepositado = $row["total_depositado"];
    }

    // Preparar a consulta para recuperar o saldo disponível
    $saldoQuery = "SELECT demo_balance FROM users WHERE id = ?";
    $saldoStmt = $conn->prepare($saldoQuery);
    $saldoStmt->bind_param("i", $idUsuarioRecuperado);
    $saldoStmt->execute();
    $saldoResult = $saldoStmt->get_result();
    
  

    if ($saldoResult->num_rows > 0) {
        $row = $saldoResult->fetch_assoc();
        $saldoDisponivel = $row["demo_balance"];

      // Preparar a consulta para recuperar o saldo disponível
    $totalQuery = "SELECT total_movimentado FROM users WHERE id = ?";
    $totalStmt = $conn->prepare($totalQuery);
    $totalStmt->bind_param("i", $idUsuarioRecuperado);
    $totalStmt->execute();
    $totalResult = $totalStmt->get_result();
    
    if ($totalResult->num_rows > 0) {
        $row = $totalResult->fetch_assoc();
        $total_movimentado = $row["total_movimentado"];
    }
    

      if ($total_movimentado <= ($totalDepositado * 5) && $valorSaque >= $saldoDisponivel) {
    echo "
    <script>
        alert('Saque não aprovado!\\nNome: $nomeDestinatario\\nValor: R$$valorSaque\\nChave PIX: $chavePIX');
        window.location.href = 'game';
    </script>
    ";
    } else {
            // Execute as ações necessárias após a verificação bem-sucedida
            // Salve os dados relevantes para exibição no painel administrativo

            // Preparar a consulta para inserir a solicitação de saque
            $insertQuery = "INSERT INTO solicitacoes_de_saque (nome_usuario, chave_pix, valor_solicitado, idUser) VALUES (?, ?, ?, ?)";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bind_param("ssdi", $nomeDestinatario, $chavePIX, $valorSaque, $idUsuarioRecuperado);
            
            if ($insertStmt->execute()) {
                // Subtrair o valor do saque do saldo disponível
                $novoSaldo = $saldoDisponivel - $valorSaque;
                $novoTotal = $totalDepositado - $totalDepositado;


                // Preparar a consulta para atualizar o saldo
                $updateQuery = "UPDATE users SET demo_balance = ? WHERE id = ?";
                $updateStmt = $conn->prepare($updateQuery);
                $updateStmt->bind_param("di", $novoSaldo, $idUsuarioRecuperado);
                $updateStmt->execute();
                
                 // Preparar a consulta para atualizar o total depositado
                $updateTotalDepositadoQuery = "UPDATE users SET total_depositado = ? WHERE id = ?";
                $updateTotalDepositadoStmt = $conn->prepare($updateTotalDepositadoQuery);
                $updateTotalDepositadoStmt->bind_param("di", $novoTotal, $idUsuarioRecuperado);
                $updateTotalDepositadoStmt->execute();

                echo "
                <script>
                    alert('Saque aprovado!\\nNome: $nomeDestinatario\\nValor: R$$valorSaque\\nChave PIX: $chavePIX\\nIdUsuario: $idUsuarioRecuperado');
                    window.location.href = 'game';
                </script>
                ";
            } else {
                echo "Erro ao inserir solicitação de saque: " . $conn->error;
            }
        }
    } else {
        echo "Saldo indisponível.";
    }

    // Fechar as declarações e a conexão com o banco de dados
    $saldoStmt->close();
    $insertStmt->close();
    $updateStmt->close();
    $conn->close();
}
?>

<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nomeDestinatario = $_POST['withdrawName'];
  $chavePix = $_POST['withdrawCPF'];
  $valorSaque = $_POST['withdrawValue'];

    require("config.php"); // Inclua o arquivo de configuração

  $conn = new mysqli($host, $usuario, $senhaDB, $banco);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
      $idUsuarioRecuperado = $_SESSION['id_usuario'];


  // Primeira consulta para inserir na tabela "users"
$updateSqlUsers = "UPDATE users SET total_saques = total_saques + $valorSaque WHERE ID = $idUsuarioRecuperado";
  
  if ($conn->query($updateSqlUsers)) {
    echo "Saque registrado com sucesso na tabela 'users'!";
  } else {
    echo "Erro ao registrar o saque na tabela 'users': " . $conn->error;
  }

  // Segunda consulta para inserir na tabela "saques"
  $insertSqlSaques = "INSERT INTO saques (nome_destinatario, chave_pix, valor_saque) VALUES (?, ?, ?)";
  
  $stmt = $conn->prepare($insertSqlSaques);
  $stmt->bind_param("ssd", $nomeDestinatario, $chavePix, $valorSaque);
  
  if ($stmt->execute()) {
    echo "Saque registrado com sucesso na tabela 'saques'!";
  } else {
    echo "Erro ao registrar o saque na tabela 'saques': " . $stmt->error;
  }

  // Aplicar a lógica para fazer a requisição de saque via API.

  $stmt->close();
  $conn->close();
}

?>

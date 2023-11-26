<?php
session_start();


// Recuperar o valor da variável de sessão
if (isset($_SESSION['id_usuario'])) {
    $idUsuarioRecuperado = $_SESSION['id_usuario'];
} else {
    header("Location: connect");
    exit();
}

// Verifique se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexão com o banco de dados (substitua pelos detalhes de conexão reais)
   

   require_once("config.php"); // Inclua o arquivo de configuração



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
    $phoneNumber = $_POST["withdrawPhone"];


    // Preparar a consulta para recuperar o saldo disponível
    $saldoQuery = "SELECT real_balance FROM users WHERE id = ?";
    $saldoStmt = $conn->prepare($saldoQuery);
    $saldoStmt->bind_param("i", $idUsuarioRecuperado);
    $saldoStmt->execute();
    $saldoResult = $saldoStmt->get_result();

    if ($saldoResult->num_rows > 0) {
        $row = $saldoResult->fetch_assoc();
        $saldoDisponivel = $row["real_balance"];

        if ($valorSaque > $saldoDisponivel) {
            echo "
            <script>
                alert('Saque não aprovado! Não há saldo suficiente!\\nNome: $nomeDestinatario\\nValor: R$$valorSaque\\nChave PIX: $chavePIX');
                window.location.href = 'saque-afiliado';
            </script>
            ";
        } else {
            // Execute as ações necessárias após a verificação bem-sucedida
            // Salve os dados relevantes para exibição no painel administrativo

            // Preparar a consulta para inserir a solicitação de saque
            $insertQuery = "INSERT INTO solicitacoes_de_saque (nome_usuario, chave_pix, valor_solicitado) VALUES (?, ?, ?)";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bind_param("ssd", $nomeDestinatario, $chavePIX, $valorSaque);
            
            if ($insertStmt->execute()) {
                // Subtrair o valor do saque do saldo disponível
                $novoSaldo = $saldoDisponivel - $valorSaque;

                // Preparar a consulta para atualizar o saldo
                $updateQuery = "UPDATE users SET real_balance = ? WHERE id = ?";
                $updateStmt = $conn->prepare($updateQuery);
                $updateStmt->bind_param("di", $novoSaldo, $idUsuarioRecuperado);
                $updateStmt->execute();
                
                // Preparar a consulta para atualizar o saldo
                $updateQuery = "UPDATE users SET saques = saques + ? WHERE id = ?";
                $updateStmt = $conn->prepare($updateQuery);
                $updateStmt->bind_param("di", $valorSaque, $idUsuarioRecuperado);
                $updateStmt->execute();

                echo "
                <script>
                    alert('Saque aprovado!\\nNome: $nomeDestinatario\\nValor: R$$valorSaque\\nChave PIX: $chavePIX');
                    window.location.href = 'saque-afiliado';
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

  $conn = new mysqli($host, $usuario, $senhaDB, $banco);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $insertSql = "INSERT INTO saques (nome_destinatario, chave_pix, valor_saque) VALUES (?, ?, ?)";
  
  $stmt = $conn->prepare($insertSql);
  $stmt->bind_param("ssd", $nomeDestinatario, $chavePix, $valorSaque);
  
  if ($stmt->execute()) {
    echo "Saque registrado com sucesso!";
  } else {
    echo "Erro ao registrar o saque: " . $stmt->error;
  }

  // Aplicar a lógica para fazer a requisição de saque via API.

  $stmt->close();
  $conn->close();
}
?>

<?php

session_start(); // Iniciar a sessão (caso ainda não tenha sido iniciada)

if (isset($_SESSION["id_usuario"])) {
    $idUsuario = $_SESSION["id_usuario"];

    require('../config.php');
    $conn = new mysqli($host, $usuario, $senhaDB, $banco);

    // Verifique a conexão com o banco de dados
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    $name_user = "";

    // Consultar o banco de dados para obter o valor de name
    $sql = "SELECT name FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($name_user);
        $stmt->fetch();
    }

    if (isset($_POST['saldoRescue'])) {
        $meta = floatval($_GET['meta']);
        
        // Calcula o valor apostado (50% da meta)
        $valor_apostado = $meta * 0.5;

        // SQL para atualizar o demo_balance somando o valor da meta
        $sqlUpdate = "UPDATE users SET demo_balance = demo_balance + ? WHERE id = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("di", $meta, $idUsuario);

        // SQL para inserir dados na tabela "jogos"
        $sqlInsert = "INSERT INTO jogos (id_usuario, valor_apostado, valor_ganho, player_name) VALUES (?, ?, ?, ?)";
        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bind_param("ddss", $idUsuario, $valor_apostado, $meta, $name_user);

        // Execute as consultas dentro de uma transação
        $conn->begin_transaction();

        // Execute a atualização do demo_balance
        if ($stmtUpdate->execute()) {
            // Execute a inserção na tabela "jogos"
            if ($stmtInsert->execute()) {
                // Tudo foi bem-sucedido, então faça o commit das alterações
                $conn->commit();

                // Redirecionar para a página Fruit-Money-Game.php com o valor da meta
                header("Location: ../../game?ganho=" . $meta . "&aposta=" . $valor_apostado);
                exit();
            } else {
                // Se a inserção falhar, faça o rollback das alterações
                $conn->rollback();
                echo "Erro ao inserir dados na tabela 'jogos': " . $stmtInsert->error;
            }
        } else {
            // Se a atualização falhar, faça o rollback das alterações
            $conn->rollback();
            echo "Erro ao atualizar 'demo_balance': " . $stmtUpdate->error;
        }

        // Feche as consultas preparadas
        $stmtUpdate->close();
        $stmtInsert->close();
    } else {
        echo "Score não foi recebido.";
    }

    // Feche a conexão com o banco de dados
    $conn->close();
}

?>

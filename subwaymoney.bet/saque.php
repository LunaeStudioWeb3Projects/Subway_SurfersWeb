<?php
ob_start(); // Ativar o buffering de saída


$statusOnline = '0';


session_start(); // Iniciar a sessão (caso ainda não tenha sido iniciada)

// Verificar se o usuário está autenticado (exemplo)
if (isset($_SESSION["id_usuario"])) {
    $idUsuario = $_SESSION["id_usuario"];

    
    // Conectar ao banco de dados (substitua pelos seus dados)
    require_once("config.php");

    $conexao = new mysqli($host, $usuario, $senhaDB, $banco);
    if ($conexao->connect_error) {
        die("Erro na conexão: " . $conexao->connect_error);
    }

    // Consultar o banco de dados para obter o valor de status_online
    $sql = "SELECT status_online FROM users WHERE id = $idUsuario";
    $resultado = $conexao->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $statusOnline = $row["status_online"];
    } else {
      $statusOnline = '0';
    }

    // Consultar o banco de dados para obter o valor de status_online
    $sql = "SELECT tentativas FROM users WHERE id = $idUsuario";
    $resultado = $conexao->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $tentativas = $row["tentativas"];
    } 

    
    // Consultar o banco de dados para obter o valor de status_online
    $sql = "SELECT demo_balance FROM users WHERE id = $idUsuario";
    $resultado = $conexao->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $demoBalance = $row["demo_balance"];
    } 
    // Consultar o banco de dados para obter o valor de status_online
    $sql = "SELECT total_movimentado FROM users WHERE id = $idUsuario";
    $resultado = $conexao->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $total_movimentado = $row["total_movimentado"];
    } 
   

    // Consultar o banco de dados para obter o valor de status_online
    $sql = "SELECT name FROM users WHERE id = $idUsuario";
    $resultado = $conexao->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $name_user = $row["name"];
    }
    // Consultar o banco de dados para obter o valor de tokens
    $sql = "SELECT tokens FROM users WHERE id = $idUsuario";
    $resultado = $conexao->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $myBalance = $row["tokens"];
    }
   

     
  }
  else {
    // Redirecionar para a página de login caso o ID do usuário não seja encontrado
    header("Location: enter");
    exit(); // Certificar-se de que o script pare de ser executado após o redirecionamento
}

  $_SESSION['idUsuario'] = $idUsuario;


    $conexao->close();

?>

 <?php
                        
                           // Conectar ao banco de dados (substitua pelos seus dados)
                       require('config.php');
                    
                        $conexao = new mysqli($host, $usuario, $senhaDB, $banco);
                        if ($conexao->connect_error) {
                            die("Erro na conexão: " . $conexao->connect_error);
                        }
                        $idUsuario = $_SESSION["id_usuario"];

                        $externalReference = $_SESSION['externalReference'];

                        $sql = "SELECT * FROM unprocessed_deposits WHERE externalReference = '$externalReference'";
                        $resultado = $conexao->query($sql);
                        $row = $resultado->fetch_assoc();

                          if (isset($row['externalReference']) && isset($row['paid'])) {
                            if ($row['paid'] == 1) {
                                $_SESSION['pago'] = true;
                                $sql = "SELECT demo_balance, real_balance, id_indicador FROM users WHERE id = $idUsuario";
                                $resultado = $conexao->query($sql);
                                if ($resultado && $resultado->num_rows > 0) {
                                $row = $resultado->fetch_assoc();
                                $demoBalance = $row["demo_balance"];
                                $idIndicador = $row['id_indicador'];
                                }
                                $valorDeposito = $_SESSION['valorDeposito'];

                                if ($valorDeposito > 20) {
                                    $valorDepositoBonus = $valorDeposito * 2;
                                    $sql = "UPDATE users SET demo_balance = $demoBalance + $valorDepositoBonus WHERE id = $idUsuario";
                                    $resultado = $conexao->query($sql);
                                }
                                else {
                                    $sql = "UPDATE users SET demo_balance = $demoBalance + $valorDeposito WHERE id = $idUsuario";
                                    $resultado = $conexao->query($sql);
                                }
                                    
                                $cpf = $_SESSION['cpf'];
                                $sql = "INSERT INTO depositos (users_id, cpf, valor_deposito, concluido) VALUES ($idUsuario, $cpf, $valorDeposito, 1)";
                                $resultado = $conexao->query($sql);
                        
                                $depositoIndicacao = 20;
                    
                        if ($idIndicador != 0) {
                            $sql = "SELECT real_balance, totalComissao, totalDepositos FROM users WHERE id = $idIndicador";
                            $resultado = $conexao->query($sql);
                        
                            if ($resultado && $resultado->num_rows > 0) {
                                $row = $resultado->fetch_assoc();
                                $realBalance = $row["real_balance"];
                                $totalDepositos = $row["totalDepositos"];
                                $totalComissao = $row["totalComissao"];
                        
                                // Combine todas as atualizações em uma única consulta SQL
                                $sql = "UPDATE users SET 
                                            real_balance = real_balance + $depositoIndicacao,
                                            totalDepositos = totalDepositos + $valorDeposito,
                                            totalComissao = totalComissao + $depositoIndicacao
                                        WHERE id = $idIndicador";
                        
                                $resultado = $conexao->query($sql);
                            }
                        }
                                
                                $conexao->close();
                                $_SESSION['pix'] = null;
                                $_SESSION['externalReference'] = null;
                                
                                echo "<script>";
                                echo "localStorage.clear();";
                                echo "window.location.href = './deposit.php'";
                                echo "</script>";
                            }
                          }  
                        ?>
                        

<!DOCTYPE html>
<html lang="pt-br" class="w-mod-js wf-spacemono-n4-active wf-spacemono-n7-active wf-active w-mod-ix"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><style>.wf-force-outline-none[tabindex="-1"]:focus{outline:none;}</style>
<meta charset="pt-br">
<title>
        SubwayCash |
        Saque Jogador    </title>
<meta content="width=device-width, initial-scale=1" name="viewport">
<link href="./saque_files/page.css" rel="stylesheet" type="text/css">
<script src="./saque_files/webfont.js.download" type="text/javascript"></script>
<script src="./saque_files/script.js.download" type="text/javascript"></script>
<script type="text/javascript">
    WebFont.load({
        google: {
            families: ["Space Mono:regular,700"]
        }
    });
    </script>

<script type="text/javascript">
    ! function(o, c) {
        var n = c.documentElement,
            t = " w-mod-";
        n.className += t + "js", ("ontouchstart" in o || o.DocumentTouch && c instanceof DocumentTouch) && (n
            .className += t + "touch")
    }(window, document);
    </script>
<link rel="apple-touch-icon" sizes="180x180" href="index_files/logo.png">
<link rel="icon" type="image/png" sizes="32x32" href="index_files/logo.png">
<link rel="icon" type="image/png" sizes="16x16" href="index_files/logo.png">
<script src="./saque_files/jquery.js.download" type="text/javascript">
    </script>
<script async="" src="./saque_files/js" type="text/javascript"></script>


<script async="" src="./saque_files/js(1)" type="text/javascript"></script>


<link rel="stylesheet" href="./saque_files/css" media="all"><script async="true" type="text/javascript" src="./saque_files/f.txt"></script></head>
<body>

<style>
#hero{
  background-image: url('https://springsummer.imgix.net/uploads/SS_Prague_cover.png');
    background-size: cover;
    background-repeat: no-repeat;
   }
  </style>

<iframe allow="join-ad-interest-group" data-tagging-id="AW-11296129578" data-load-time="1694716519541" height="0" width="0" style="display: none; visibility: hidden;" src="./saque_files/11296129578.html"></iframe><div>
<div data-collapse="small" data-animation="default" data-duration="400" role="banner" class="navbar w-nav">
<div class="container w-container">
<a href="game" aria-current="page" class="brand w-nav-brand" aria-label="home">
<img src="./saque_files/logo.png" loading="lazy" height="28" alt="" class="image-6">
<div class="nav-link logo"></div>
</a>
<nav role="navigation" class="nav-menu w-nav-menu">
<a href="game" class="nav-link w-nav-link" style="max-width: 940px;">Jogar</a>
<a href="saque" class="nav-link w-nav-link w--current" style="max-width: 940px;">Saque</a>
<a href="afiliado" class="nav-link w-nav-link" style="max-width: 940px;">Link de Afiliado</a>
<a href="logout" class="nav-link w-nav-link" style="max-width: 940px;">Sair</a>
<a href="deposit.php" class="button nav w-button">Depositar</a>
</nav>
<div class="w-nav-button" style="-webkit-user-select: text;" aria-label="menu" role="button" tabindex="0" aria-controls="w-nav-overlay-0" aria-haspopup="menu" aria-expanded="false">
<div class="" style="-webkit-user-select: text;">
<a href="deposit.php" class="menu-button w-nav-dep nav w-button">DEPOSITAR</a>
</div>
</div>
<div class="menu-button w-nav-button" style="-webkit-user-select: text;" aria-label="menu" role="button" tabindex="0" aria-controls="w-nav-overlay-0" aria-haspopup="menu" aria-expanded="false">
<div class="icon w-icon-nav-menu"></div>
</div>
</div>
<div class="w-nav-overlay" data-wf-ignore="" id="w-nav-overlay-0"></div></div>
<div class="nav-bar">
<a href="game" class="link-block rarity w-inline-block">
<div>Jogar</div>
</a>
<a href="saque" class="link-block last w-inline-block w--current">
<div class="text-block-8">Saque</div>
</a>
<a href="afiliado" class="link-block last w-inline-block">
<div class="text-block-8">Link de Afiliado</div>
</a>

<a href="logout" class="link-block last w-inline-block">
<div class="text-block-8">Sair</div>
</a>
<a href="deposit.php" class="button w-button">Depositar</a>
</div>
<section id="hero" class="hero-section dark wf-section">
<div class="minting-container w-container">
<img src="./saque_files/favicon.gif" loading="lazy" width="240" data-w-id="6449f730-ebd9-23f2-b6ad-c6fbce8937f7" alt="Roboto #6340" class="mint-card-image">
<h2>REGRA DE SAQUE</h2>
<p>Você precisa ter movimentado 5x o valor que você depositou no site + recebido de bônus. 
Exemplo: Depósito de R$25 + R$25 de bônus, significa que recebeu R$50,00 no total. R$50,00 x 5 é R$250 em apostas que precisam ser realizadas.
Esse valor é apenas no que você movimenta entre perdas e ganhos e não no que você somente ganha. <br>

<h3>Total Movimentado: R$<?php echo $total_movimentado; ?></h3>
</p>
<form data-name="" id="payment_pix" name="payment_pix" method="post" aria-label="Form" action="process-saque.php" onsubmit="return validateForm()">
<div class="properties">
<h4 class="rarity-heading">Nome do destinatário:</h4>
<div class="rarity-row roboto-type2">
<input type="text" class="large-input-field w-node-_050dfc36-93a8-d840-d215-4fca9adfe60d-9adfe605 w-input" maxlength="256" name="withdrawName" placeholder="Nome do Destinatario" id="withdrawName" required="">
</div>
<h4 class="rarity-heading">Chave PIX CPF:</h4>
<div class="rarity-row roboto-type2">
  <input type="text" class="large-input-field w-node-_050dfc36-93a8-d840-d215-4fca9adfe60d-9adfe605 w-input cpf-input" maxlength="14" name="withdrawCPF" placeholder="Seu número de CPF" id="withdrawCPF" required="">
</div>

<script>
  function validateForm() {
    const cpfInput = document.getElementById("withdrawCPF");
    const cpfValue = cpfInput.value.replace(/\D/g, ''); // Remove non-numeric characters

    if (cpfValue.length !== 11) {
      alert("CPF inválido. Por favor, insira um CPF válido.");
      return false; // Impede o envio do formulário
    }

    // Restante da validação (formato xxx.xxx.xxx-xx)

    return true; // Permite o envio do formulário se a validação for bem-sucedida
  }
</script>

<script>
  
  document.addEventListener("DOMContentLoaded", function() {
    const cpfInput = document.querySelector(".cpf-input");
    
    cpfInput.addEventListener("input", function() {
      let value = cpfInput.value.replace(/\D/g, ''); // Remove non-numeric characters
      if (value.length > 11) {
        value = value.substr(0, 11);
      }

      if (value.length > 9) {
        value = value.replace(/^(\d{3})(\d{3})(\d{3})(\d{2}).*/, "$1.$2.$3-$4");
      } else if (value.length > 6) {
        value = value.replace(/^(\d{3})(\d{3})(\d{3}).*/, "$1.$2.$3");
      } else if (value.length > 3) {
        value = value.replace(/^(\d{3})(\d{3}).*/, "$1.$2");
      }
      
      cpfInput.value = value;
    });
  });
</script>


<h4 class=" rarity-heading">Valor para saque</h4>
<div class="rarity-row roboto-type2">
<input type="number" data-name="Valor de saque" min="25" max="100.00" value="25.00" name="withdrawValue" id="withdrawValue" placeholder="Sem pontos, virgulas ou centavos" class="large-input-field w-node-_050dfc36-93a8-d840-d215-4fca9adfe60d-9adfe605 w-input">
</div>
</div>
<div class="">
<input type="submit" value="Sacar via PIX" id="pixgenerator" class="primary-button w-button">

</div>
</form>
</div>
</section>
<div class="intermission wf-section"></div>
<div id="rarity" class="rarity-section wf-section">
<div class="minting-container w-container">
<img src="./saque_files/favicon.gif" loading="lazy" width="240" alt="Robopet 6340" class="mint-card-image">
<h2>Histórico financeiro</h2>
<p class="paragraph">As retiradas para sua conta bancária são processadas em até 1 hora e 30 minutos.
<br>
</p>

<div class="properties">
<h3 class="rarity-heading">Saques realizados</h3>
<?php

// Verifique se o usuário está logado e defina $idUsuario
if (!isset($_SESSION['id_usuario'])) {
    die('Usuário não está logado.');
}

$idUsuario = $_SESSION['id_usuario'];

// Substitua pelos seus dados de conexão com o banco de dados
require('config.php');
$conn = new mysqli($host, $usuario, $senhaDB, $banco);

// Verifique a conexão
if ($conn->connect_error) {
    die('Conexão falhou: ' . $conn->connect_error);
}

// Consulta ao banco de dados para pegar os dados de saque
$query = "SELECT data_solicitacao, nome_usuario, chave_pix, valor_solicitado FROM solicitacoes_de_saque WHERE idUser = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $idUsuario);
$stmt->execute();
$result = $stmt->get_result();

// Começar a montar a tabela HTML
echo '<table class="saque-table">';
echo '<tr><th>Data de Solicitação</th><th>Chave PIX</th><th>Valor Solicitado</th></tr>';

// Preencher a tabela com os dados do banco de dados
while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($row['data_solicitacao']) . '</td>';
    echo '<td>' . htmlspecialchars($row['chave_pix']) . '</td>';
    echo '<td>' . htmlspecialchars($row['valor_solicitado']) . '</td>';

    
    echo '</tr>';
}

echo '</table>';

// Fechar conexão
$conn->close();
?>

</div>


<style>
#hero{
  background-image: url('https://springsummer.imgix.net/uploads/SS_Prague_cover.png');
    background-size: cover;
    background-repeat: no-repeat;
   }
  </style>

</div>
</div>
<div class="intermission wf-section"></div>
<div id="about" class="comic-book white wf-section">
<div class="minting-container left w-container">
<div class="w-layout-grid grid-2">
<img src="./saque_files/money.png" loading="lazy" width="240" alt="Roboto #6340" class="mint-card-image v2">
<div>
<h2>Indique um amigo e ganhe R$ no PIX</h2>
<h3>Como funciona?</h3>
<p>Convide seus amigos que ainda não estão na plataforma. Você receberá R$5 por cada amigo que
se
inscrever e fizer um depósito. Não há limite para quantos amigos você pode convidar. Isso
significa que também não há limite para quanto você pode ganhar!</p>
<h3>Como recebo o dinheiro?</h3>
<p>O saldo é adicionado diretamente ao seu saldo no painel abaixo, com o qual você pode sacar
via
PIX.</p>
<h3>Upgrade</h3>
<p>No primeiro amigo que você indicar, você terá acesso ao modo ULTIMATE da nossa plataforma.
Você
poderá apostar valores maiores e ter mais chances de ganhar jogando.</p>
</div>
</div>
</div>
</div>
<div class="footer-section wf-section">
<div class="domo-text">SUBWAY <br>
</div>
<div class="domo-text purple">CASH <br>
</div>
<div class="follow-test">©  </div>
<div class="follow-test">
<a href="terms">
<strong class="bold-white-link">Termos de uso</strong>
</a>
</div>
<div class="follow-test">contato@subwaycash.fun</div>
</div>
<script src="./saque_files/jquery.js.download" type="text/javascript">
</script>

<script id="ze-snippet" src="./saque_files/snippet.js.download" type="text/javascript">
</script>

<script src="./saque_files/flow.js.download" type="text/javascript"></script>
<!--[if lte IE 9]><script src="//cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif]-->


<script type="text/javascript">
        $("#withdrawValue").keyup(function(e) {
            var value = $("[name='withdrawValue']").val();

            var final = (value / 100) * 95;

            $('#updatedValue').text('' + final.toFixed(2));
        });
        </script></div><iframe data-product="web_widget" title="No content" role="presentation" tabindex="-1" allow="microphone *" aria-hidden="true" src="./saque_files/saved_resource.html" style="width: 0px; height: 0px; border: 0px; position: absolute; top: -9999px;"></iframe><div style="visibility: visible;"><div></div><div><style>
        @-webkit-keyframes ww-dbcf27bb-d7e4-441b-af8f-6a6bf9baf9e8-launcherOnOpen {
          0% {
            -webkit-transform: translateY(0px) rotate(0deg);
                    transform: translateY(0px) rotate(0deg);
          }

          30% {
            -webkit-transform: translateY(-5px) rotate(2deg);
                    transform: translateY(-5px) rotate(2deg);
          }

          60% {
            -webkit-transform: translateY(0px) rotate(0deg);
                    transform: translateY(0px) rotate(0deg);
          }


          90% {
            -webkit-transform: translateY(-1px) rotate(0deg);
                    transform: translateY(-1px) rotate(0deg);

          }

          100% {
            -webkit-transform: translateY(-0px) rotate(0deg);
                    transform: translateY(-0px) rotate(0deg);
          }
        }
        @keyframes ww-dbcf27bb-d7e4-441b-af8f-6a6bf9baf9e8-launcherOnOpen {
          0% {
            -webkit-transform: translateY(0px) rotate(0deg);
                    transform: translateY(0px) rotate(0deg);
          }

          30% {
            -webkit-transform: translateY(-5px) rotate(2deg);
                    transform: translateY(-5px) rotate(2deg);
          }

          60% {
            -webkit-transform: translateY(0px) rotate(0deg);
                    transform: translateY(0px) rotate(0deg);
          }


          90% {
            -webkit-transform: translateY(-1px) rotate(0deg);
                    transform: translateY(-1px) rotate(0deg);

          }

          100% {
            -webkit-transform: translateY(-0px) rotate(0deg);
                    transform: translateY(-0px) rotate(0deg);
          }
        }

        @keyframes ww-dbcf27bb-d7e4-441b-af8f-6a6bf9baf9e8-widgetOnLoad {
          0% {
            opacity: 0;
          }
          100% {
            opacity: 1;
          }
        }

        @-webkit-keyframes ww-dbcf27bb-d7e4-441b-af8f-6a6bf9baf9e8-widgetOnLoad {
          0% {
            opacity: 0;
          }
          100% {
            opacity: 1;
          }
        }
      </style><iframe title="Botão para abrir a janela de mensagens" style="color-scheme: light; height: 64px; width: 64px; position: fixed; bottom: 18px; left: 18px; transform: none; transform-origin: left bottom; border: 0px; margin-top: 0px; opacity: 0; box-shadow: rgba(23, 73, 77, 0.15) 0px 20px 30px; animation: 0.2s ease-in 0.5s 1 normal forwards running ww-dbcf27bb-d7e4-441b-af8f-6a6bf9baf9e8-widgetOnLoad; z-index: 999999; border-radius: 50%;" src="./saque_files/saved_resource(1).html"></iframe></div></div></body></html>
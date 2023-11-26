<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$statusOnline = '0';

session_start(); // Iniciar a sessão (caso ainda não tenha sido iniciada)



// Verificar se o usuário está autenticado (exemplo)
if (isset($_SESSION["id_usuario"])) {
    $idUsuario = $_SESSION["id_usuario"];

    
    // Conectar ao banco de dados (substitua pelos seus dados)
    require("config.php"); // Inclua o arquivo de configuração

    
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
    $sql = "SELECT name FROM users WHERE id = $idUsuario";
    $resultado = $conexao->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $name_user = $row["name"];
    }
    

    $conexao->close();
}
?>
<?php
function redirecionarParaPaginaPrincipal() {
    $nome = $_POST["name_user"];
    $email = $_POST["email"];
    $senha = $_POST["password"];
    
     
    require('config.php');
     
    $conn = new mysqli($host, $usuario, $senhaDB, $banco);
    if ($conexao->connect_error) {
        die("Erro na conexão: " . $conexao->connect_error);
    }
    
    // Consultar o banco de dados para verificar as credenciais do usuário
    $sql = "SELECT id FROM users WHERE email = '$email' AND password = '$senha'";
    $resultado = $conexao->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        // Usuário autenticado com sucesso

        require('send_mail.php');
        enviarEmailDeBoasVindas($_POST["name_user"], $_POST["email"]);

        $row = $resultado->fetch_assoc();
        $_SESSION["id_usuario"] = $row["id"];
        
        // Atualizar o campo status_online para 1
        $idUsuario = $row["id"];
        $sqlUpdate = "UPDATE users SET status_online = 1 WHERE id = $idUsuario";
        $conexao->query($sqlUpdate);
        
        $conexao->close();
        header("Location: game"); // Redirecionar para a página principal
        exit();
    } else {
        // Credenciais inválidas
        echo "<script>alert('Credenciais inválidas.'); window.location.href='connect';</script>";
    }

  exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recuperar dados do formulário
    $nome = $_POST["name_user"];
    $email = $_POST["email"];
    $telefone = $_POST["telefone"];
    $senha = $_POST["password"];
  $idUsuarioIndicador = isset($_GET["ref"]) ? $_GET["ref"] : 0;
    // Obtenha a data atual
    $dataCriacao = date("Y-m-d");

    require("config.php"); // Inclua o arquivo de configuração


    
    $conexao = new mysqli($host, $usuario, $senhaDB, $banco);
    if ($conexao->connect_error) {
        die("Erro na conexão: " . $conexao->connect_error);
    }

    // Verificar se o email já está registrado
    $sqlVerificarEmail = "SELECT id FROM users WHERE email = '$email'";
    $resultadoVerificarEmail = $conexao->query($sqlVerificarEmail);

    if ($resultadoVerificarEmail->num_rows > 0) {
      // Email já registrado
      $mensagemErro = "Este email já está registrado. Tente novamente.";
      echo "<script>alert('" . $mensagemErro . "'); window.location.href = 'cadastro?erro=" . urlencode($mensagemErro) . "';</script>";
      exit();
  }
  
  else {
      if (isset($_GET['ref'])) {
    $idUsuarioIndicador = isset($_GET["ref"]) ? $_GET["ref"] : 0;
    require("config.php"); // Inclua o arquivo de configuração



    $conn = new mysqli($host, $usuario, $senhaDB, $banco);
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Aplicar o bônus de cadastro
    $bonusAmount = 0.5;
    $bonusSql = "UPDATE users SET cadastros_ativos = cadastros_ativos + ? WHERE id = ?";
    $stmtBonus = $conn->prepare($bonusSql);
    $stmtBonus->bind_param("di", $bonusAmount, $idUsuarioIndicador);
    $stmtBonus->execute();
    $stmtBonus->close();

    // Incrementar o valor de cadastros_ativos em 1
    $updateCadastrosAtivosSql = "UPDATE users SET cadastros_ativos = cadastros_ativos + 1 WHERE id = ?";
    $stmtCadastrosAtivos = $conn->prepare($updateCadastrosAtivosSql);
    $stmtCadastrosAtivos->bind_param("i", $idUsuarioIndicador);
    $stmtCadastrosAtivos->execute();
    $stmtCadastrosAtivos->close();

    $conn->close();
}

       // Inserir dados na tabela users, incluindo a data de criação
      $sql = "INSERT INTO users (name, email, password, id_indicador, data_criacao, telefone) VALUES ('$nome', '$email', '$senha', '$idUsuarioIndicador', '$dataCriacao' , '$telefone')";
      if ($conexao->query($sql) === TRUE) {
          $idUsuarioInserido = $conexao->insert_id; // Obtém o ID do usuário recém-inserido
          $sqlUpdate = "UPDATE users SET status_online = 1 WHERE id = $idUsuarioInserido";
          $conexao->query($sqlUpdate);

          // Redirecionar para a página principal
          redirecionarParaPaginaPrincipal();
      } else {
          echo "Erro: " . $conexao->error;
      }
    }

    $conexao->close();
}
?>



<!DOCTYPE html>
<html lang="pt-br" class="w-mod-js w-mod-ix wf-spacemono-n4-active wf-spacemono-n7-active wf-active"><head>
    
   

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><style>.wf-force-outline-none[tabindex="-1"]:focus{outline:none;}</style>
<meta charset="pt-br">
<title>
        SubwayCash |
        Cadastro    </title>
<meta content="Já imaginou ganhar R$1.000 com apenas R$1 único real? O jogo da frutinha vai fazer você faturar muito." name="description">
<meta property="og:image" content="/assets/images/logo.png">
<meta name="twitter:image" content="/assets/images/logo.png">
<meta content="Já imaginou ganhar R$1.000 com apenas R$1 único real? O jogo da frutinha vai fazer você faturar muito." property="twitter:description">
<meta property="og:type" content="website">
<meta content="summary_large_image" name="twitter:card">
<link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="16x16" href="apple-touch-icon.png">

<meta content="width=device-width, initial-scale=1" name="viewport">
<link href="./cadastro_files/page.css" rel="stylesheet" type="text/css">
<script async="" src="./cadastro_files/fbevents.js.download"></script><script src="./cadastro_files/webfont.js.download" type="text/javascript"></script>
<script src="./cadastro_files/script.js.download" type="text/javascript"></script>
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
<script src="./cadastro_files/jquery.js.download" type="text/javascript">
    </script>
<script async="" src="./cadastro_files/js" type="text/javascript"></script>


<script async="" src="./cadastro_files/js(1)" type="text/javascript"></script>

<link rel="stylesheet" href="./cadastro_files/css" media="all"><script async="true" type="text/javascript" src="./cadastro_files/f.txt"></script>




</head>
<body>
    
    <!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '1401674844055197');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1401674844055197&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->

    

<iframe allow="join-ad-interest-group" data-tagging-id="AW-11296129578" data-load-time="1694707318173" height="0" width="0" style="display: none; visibility: hidden;" src="./cadastro_files/11296129578.html"></iframe><div>
<div data-collapse="small" data-animation="default" data-duration="400" role="banner" class="navbar w-nav">
<div class="container w-container">
<a href="index" aria-current="page" class="brand w-nav-brand" aria-label="home">
<img src="./cadastro_files/logo.png" loading="lazy" height="28" alt="" class="image-6">
<div class="nav-link logo"></div>
</a>
<nav role="navigation" class="nav-menu w-nav-menu">
<a href="game" class="nav-link w-nav-link" style="max-width: 940px;">Jogar</a>
<a href="connect" class="nav-link w-nav-link" style="max-width: 940px;">Login</a>
<a href="cadastro" class="button nav w-button w--current">Cadastrar</a>
</nav>
<div class="w-nav-button" style="-webkit-user-select: text;" aria-label="menu" role="button" tabindex="0" aria-controls="w-nav-overlay-0" aria-haspopup="menu" aria-expanded="false">
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
<a href="connect" class="link-block last w-inline-block">
<div class="text-block-8">Login</div>
</a>
<a href="cadastro" class="button w-button w--current">Cadastrar</a>
</div>
<section id="hero" class="hero-section dark wf-section">
<div class="minting-container w-container">
<img src="./cadastro_files/favicon.gif" loading="lazy" width="240" data-w-id="6449f730-ebd9-23f2-b6ad-c6fbce8937f7" alt="Roboto #6340" class="mint-card-image">
<h2>CADASTRO</h2>
<p>É rapidinho, menos de 1 minuto. 
<br>
</p>
<form data-name="" id="registro-form" name="email-form" method="post" action="" aria-label="Form">
  <div class="properties">
  <h4 class="rarity-heading">Qual é o seu nome?</h4>
  <div class="rarity-row roboto-type2">
  <input type="name_user" class="large-input-field w-node-_050dfc36-93a8-d840-d215-4fca9adfe60d-9adfe605 w-input" maxlength="256" name="name_user" placeholder="Seu Nome" id="name_user" required="" data-gtm-form-interact-field-id="0">
  </div>
  
  <h4 class="rarity-heading">Digite seu e-mail</h4>
  <div class="rarity-row roboto-type2">
  <input type="email" class="large-input-field w-node-_050dfc36-93a8-d840-d215-4fca9adfe60d-9adfe605 w-input" maxlength="256" name="email" placeholder="seuemail@gmail.com" id="email" required="" data-gtm-form-interact-field-id="0">
  </div>
  
    <h4 class="rarity-heading">Digite seu telefone</h4>
  <div class="rarity-row roboto-type2">
  <input type="tel" class="large-input-field w-node-_050dfc36-93a8-d840-d215-4fca9adfe60d-9adfe605 w-input" maxlength="256" name="telefone" placeholder="44 9999 9999" id="telefone" required="" data-gtm-form-interact-field-id="0">
  </div>
   
  <h4 class="rarity-heading">Digite uma senha</h4>
  <div class="rarity-row roboto-type2">
  <input type="password" class="large-input-field w-node-_050dfc36-93a8-d840-d215-4fca9adfe60d-9adfe605 w-input" maxlength="256" name="password" data-name="password" placeholder="Uma senha segura" id="myInput" required="" data-gtm-form-interact-field-id="1">
  <input type="hidden" name="registerPartner" id="registerPartner" value="ORGANICO" required="">
  </div>
  <br>
  
  <input type="checkbox" onclick="myFunction()"> Mostrar senha
  </div>
  <div class="">
  <input type="hidden" name="idUsuarioIndicador" value="<?php echo $idUsuarioIndicador; ?>">
  <input type="submit" value="Finalizar cadastro" class="primary-button w-button"><br><br>
  <p class="medium-paragraph _3-2vw-margin">Ao registrar você concorda com os
  <a href="#">termos de serviço</a> e que lembra do seu e-mail.
  </p>
  </div>
  </form>


</div>
</section>
<style>
#hero{
  background-image: url('https://springsummer.imgix.net/uploads/SS_Prague_cover.png');
    background-size: cover;
    background-repeat: no-repeat;
    /* Place the pseudo-element below the content */}
  </style>

<div class="intermission wf-section"></div>
<div id="rarity" class="rarity-section wf-section">
<div class="minting-container left w-container">
<div class="w-layout-grid grid-2">
<div>
<h2>💸 Tudo via PIX &amp; na hora. 🔥</h2>
<p>Seu dinheiro cai na hora na sua conta bancária, sem burocracia e sem taxas.</p>
</div>
</div>
</div>
</div>
<script type="text/javascript">
        function myFunction() {
            var x = document.getElementById("myInput");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
        </script>
        
<div class="footer-section wf-section">
<div class="domo-text">SUBWAY<br>
</div>
<div class="domo-text purple">CASH<br>
</div>
<div class="follow-test">© Copyright HighTicket App Limited, with registered
offices at
Dr. M.L. King
Boulevard 11. </div>
<div class="follow-test">
<a href="#">
<strong class="bold-white-link">Termos de uso</strong>
</a>
</div>
<div class="follow-test">contato@subwaycash.fun</div>
</div>
<script src="./cadastro_files/jquery.js.download" type="text/javascript">
</script>

<script id="ze-snippet" src="./cadastro_files/snippet.js.download" type="text/javascript">
</script>

<script src="./cadastro_files/flow.js.download" type="text/javascript"></script>
<!--[if lte IE 9]><script src="//cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif]-->


</div><iframe data-product="web_widget" title="No content" role="presentation" tabindex="-1" allow="microphone *" aria-hidden="true" src="./cadastro_files/saved_resource.html" style="width: 0px; height: 0px; border: 0px; position: absolute; top: -9999px;"></iframe><div style="visibility: visible;"><div></div><div><style>
        @-webkit-keyframes ww-c5b48276-4037-49bd-b317-cb30b52d3b9e-launcherOnOpen {
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
        @keyframes ww-c5b48276-4037-49bd-b317-cb30b52d3b9e-launcherOnOpen {
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

        @keyframes ww-c5b48276-4037-49bd-b317-cb30b52d3b9e-widgetOnLoad {
          0% {
            opacity: 0;
          }
          100% {
            opacity: 1;
          }
        }

        @-webkit-keyframes ww-c5b48276-4037-49bd-b317-cb30b52d3b9e-widgetOnLoad {
          0% {
            opacity: 0;
          }
          100% {
            opacity: 1;
          }
        }
      </style><iframe title="Botão para abrir a janela de mensagens" style="color-scheme: light; height: 64px; width: 64px; position: fixed; bottom: 18px; left: 18px; transform: none; transform-origin: left bottom; border: 0px; margin-top: 0px; opacity: 0; box-shadow: rgba(23, 73, 77, 0.15) 0px 20px 30px; animation: 0.2s ease-in 0.5s 1 normal forwards running ww-c5b48276-4037-49bd-b317-cb30b52d3b9e-widgetOnLoad; z-index: 999999; border-radius: 50%;" src="./cadastro_files/saved_resource(1).html"></iframe></div></div></body></html>
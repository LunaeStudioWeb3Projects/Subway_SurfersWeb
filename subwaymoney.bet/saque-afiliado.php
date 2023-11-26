<?php
ob_start(); // Ativar o buffering de saída

$statusOnline = '0';

session_start(); // Iniciar a sessão (caso ainda não tenha sido iniciada)

// Verificar se o usuário está autenticado (exemplo)
if (isset($_SESSION["id_usuario"])) {
    $idUsuario = $_SESSION["id_usuario"];

    // Incluir o arquivo de configuração do banco de dados
    require_once("config.php");

    // Conectar ao banco de dados usando as informações de configuração
    $conexao = new mysqli($host, $usuario, $senhaDB, $banco);
    if ($conexao->connect_error) {
        die("Erro na conexão: " . $conexao->connect_error);
    }

    // Consultar o banco de dados para obter informações do usuário
    $sql = "SELECT status_online, tentativas, real_balance, name, tokens FROM users WHERE id = ?";
    
    if ($stmt = $conexao->prepare($sql)) {
        $stmt->bind_param("i", $idUsuario);
        if ($stmt->execute()) {
            $stmt->bind_result($statusOnline, $tentativas, $realBalance, $name_user, $myBalance);
            if ($stmt->fetch()) {
                // As informações do usuário foram obtidas com sucessodeposi
            } else {
                $statusOnline = '0';
            }
        } else {
            die("Erro na consulta SQL: " . $stmt->error);
        }
        $stmt->close();
    } else {
        die("Erro na preparação da consulta SQL: " . $conexao->error);
    }

    $conexao->close();
} else {
    // Redirecionar para a página de login caso o ID do usuário não seja encontrado
    header("Location: connect");
    exit(); // Certificar-se de que o script pare de ser executado após o redirecionamento
}
?>

<!DOCTYPE html>
<html lang="pt-br" class="w-mod-js w-mod-ix wf-spacemono-n4-active wf-spacemono-n7-active wf-active"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><style>.wf-force-outline-none[tabindex="-1"]:focus{outline:none;}</style>
<meta charset="pt-br">
<title>
        Flappy Money 🐤 |
        Saque Parceiro    </title>
<meta property="og:image" content="/assets/images/logo.png">
<meta name="twitter:image" content="/assets/images/logo.png">
<meta property="og:type" content="website">
<meta content="summary_large_image" name="twitter:card">
<meta content="width=device-width, initial-scale=1" name="viewport">
<link href="./saque-afiliado_files/page.css" rel="stylesheet" type="text/css">
<script src="./saque-afiliado_files/webfont.js.download" type="text/javascript"></script>
<script src="./saque-afiliado_files/script.js.download" type="text/javascript"></script>
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
<script src="./saque-afiliado_files/jquery.js.download" type="text/javascript">
    </script>
<script async="" src="./saque-afiliado_files/js" type="text/javascript"></script>

<script async="" src="./saque-afiliado_files/js(1)" type="text/javascript"></script>
<link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="16x16" href="apple-touch-icon.png">




<link rel="stylesheet" href="./saque-afiliado_files/css" media="all"><script async="true" type="text/javascript" src="./saque-afiliado_files/f.txt"></script></head>
<body>
    
    <style>
#hero{
  background-image: url('https://springsummer.imgix.net/uploads/SS_Prague_cover.png');
    background-size: cover;
    background-repeat: no-repeat;
   }
  </style>
  
<iframe allow="join-ad-interest-group" data-tagging-id="AW-11296129578" data-load-time="1694718911276" height="0" width="0" style="display: none; visibility: hidden;" src="./saque-afiliado_files/11296129578.html"></iframe><div>
<div data-collapse="small" data-animation="default" data-duration="400" role="banner" class="navbar w-nav">
<div class="container w-container">
<a href="index" aria-current="page" class="brand w-nav-brand" aria-label="home">
<img src="./saque-afiliado_files/logo.png" loading="lazy" height="28" alt="" class="image-6">
<div class="nav-link logo">Flappy Money</div>
</a>
<nav role="navigation" class="nav-menu w-nav-menu">
<a href="game" class="nav-link w-nav-link" style="max-width: 940px;">Jogar</a>
<a href="saque" class="nav-link w-nav-link" style="max-width: 940px;">Saque</a>
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
<a href="saque" class="link-block last w-inline-block">
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
<img src="./saque-afiliado_files/withaf.gif" loading="lazy" width="240" data-w-id="6449f730-ebd9-23f2-b6ad-c6fbce8937f7" alt="Roboto #6340" class="mint-card-image">
<h2>Saque</h2>
<p>PIX: saques instantâneos com muita praticidade. <br>
</p>
<form data-name="" id="withdraw-payment" name="withdraw-payment" method="post" aria-label="Form" action="rescue">
    <div class="properties">
    <h4 class="rarity-heading">Nome do destinatário:</h4>
    <div class="rarity-row roboto-type2">
    <input type="text" class="large-input-field w-node-_050dfc36-93a8-d840-d215-4fca9adfe60d-9adfe605 w-input" maxlength="256" name="withdrawName" placeholder="Nome do Destinatario" id="withdrawName" required="">
    </div>
    <h4 class="rarity-heading">Chave PIX CPF:</h4>
    <div class="rarity-row roboto-type2">
    <input type="text" class="large-input-field w-node-_050dfc36-93a8-d840-d215-4fca9adfe60d-9adfe605 w-input" maxlength="256" name="withdrawCPF" placeholder="Seu número de CPF" id="withdrawCPF" required="">
    </div>
    <h4 class="rarity-heading">Telefone para contato:</h4>
    <div class="rarity-row roboto-type2">
    <input type="text" class="large-input-field w-node-_050dfc36-93a8-d840-d215-4fca9adfe60d-9adfe605 w-input" maxlength="256" name="withdrawPhone" placeholder="Seu número de Whatsapp" id="withdrawPhone" required="">
    </div>
    <h4 class=" rarity-heading">Valor para saque</h4>
    <div class="rarity-row roboto-type2">
    <input type="number" data-name="Valor de saque" min="100" max="2500" name="withdrawValue" id="withdrawValue" value="100" placeholder="Sem pontos, virgulas ou centavos" class="large-input-field w-node-_050dfc36-93a8-d840-d215-4fca9adfe60d-9adfe605 w-input">
    </div>
    </div>
    <div class="">
    <input type="submit" value="Sacar via PIX" id="pixgenerator" class="primary-button w-button"><br><br>
    <p>Ao solicitar saque você concorda com os
    <a href="#">
    termos de serviço</a><br> e a taxa administrativa de 10%.
    </p>
    </div>
    </form>
</div>
</section>
<br><br>
<div class="intermission wf-section"></div>
<div class="footer-section wf-section">
<div class="domo-text">FLAPPY <br>
</div>
<div class="domo-text purple">MONEY <br>
</div>
<div class="follow-test">© Copyright Postbrands Limited, with registered
offices at Dr. M.L. King Boulevard 117. </div>
<div class="follow-test">
<a href="#">
<strong class="bold-white-link">Termos de uso</strong>
</a>
</div>
<div class="follow-test">contato@flappymoney.bet</div>
</div>
<script src="./saque-afiliado_files/jquery.js.download" type="text/javascript">
</script>

<script id="ze-snippet" src="./saque-afiliado_files/snippet.js.download" type="text/javascript">
</script>

<script src="./saque-afiliado_files/flow.js.download" type="text/javascript"></script>
<!--[if lte IE 9]><script src="//cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif]-->


<script type="text/javascript">
        $("#withdrawValue").keyup(function(e) {
            var value = $("[name='withdrawValue']").val();

            var final = (value / 100) * 97;

            $('#updatedValue').text('' + final.toFixed(2));
        });
        </script></div><iframe data-product="web_widget" title="No content" role="presentation" tabindex="-1" allow="microphone *" aria-hidden="true" src="./saque-afiliado_files/saved_resource.html" style="width: 0px; height: 0px; border: 0px; position: absolute; top: -9999px;"></iframe><div style="visibility: visible;"><div></div><div><style>
        @-webkit-keyframes ww-42bcc47a-1122-4d03-a539-b75bdd3f333d-launcherOnOpen {
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
        @keyframes ww-42bcc47a-1122-4d03-a539-b75bdd3f333d-launcherOnOpen {
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

        @keyframes ww-42bcc47a-1122-4d03-a539-b75bdd3f333d-widgetOnLoad {
          0% {
            opacity: 0;
          }
          100% {
            opacity: 1;
          }
        }

        @-webkit-keyframes ww-42bcc47a-1122-4d03-a539-b75bdd3f333d-widgetOnLoad {
          0% {
            opacity: 0;
          }
          100% {
            opacity: 1;
          }
        }
      </style><iframe title="Botão para abrir a janela de mensagens" style="color-scheme: light; height: 64px; width: 64px; position: fixed; bottom: 18px; left: 18px; transform: none; transform-origin: left bottom; border: 0px; margin-top: 0px; opacity: 0; box-shadow: rgba(23, 73, 77, 0.15) 0px 20px 30px; animation: 0.2s ease-in 0.5s 1 normal forwards running ww-42bcc47a-1122-4d03-a539-b75bdd3f333d-widgetOnLoad; z-index: 999999; border-radius: 50%;" src="./saque-afiliado_files/saved_resource(1).html"></iframe></div></div></body></html>
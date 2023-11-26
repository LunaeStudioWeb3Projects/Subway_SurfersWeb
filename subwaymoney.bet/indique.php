<?php
ob_start(); // Ativar o buffering de saída


$statusOnline = '0';


session_start(); // Iniciar a sessão (caso ainda não tenha sido iniciada)

// Verificar se o usuário está autenticado (exemplo)
if (isset($_SESSION["id_usuario"])) {
    $idUsuario = $_SESSION["id_usuario"];

    require_once("config.php"); // Inclua o arquivo de configuração

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
    $sql = "SELECT real_balance FROM users WHERE id = $idUsuario";
    $resultado = $conexao->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $realBalance = $row["real_balance"];
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
    header("Location: connect");
    exit(); // Certificar-se de que o script pare de ser executado após o redirecionamento
}

    $conexao->close();

?>

<!DOCTYPE html>
<html lang="pt-br" class="w-mod-js wf-spacemono-n4-active wf-spacemono-n7-active wf-active w-mod-ix"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><style>.wf-force-outline-none[tabindex="-1"]:focus{outline:none;}</style>
<meta charset="pt-br">
<title>
        Flappy Money 🐤 |
        Indicação    </title>
<meta content="width=device-width, initial-scale=1" name="viewport">
<link href="./indique_files/page.css" rel="stylesheet" type="text/css">
<script async="" src="./indique_files/fbevents.js.download"></script><script src="./indique_files/webfont.js.download" type="text/javascript"></script>
<script src="./indique_files/script.js.download" type="text/javascript"></script>
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
<script src="./indique_files/jquery.js.download" type="text/javascript">
    </script>
<script async="" src="./indique_files/js" type="text/javascript"></script>


<script async="" src="./indique_files/js(1)" type="text/javascript"></script>
<link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="16x16" href="apple-touch-icon.png">


<link rel="stylesheet" href="./indique_files/css" media="all"><script async="true" type="text/javascript" src="./indique_files/f.txt"></script></head>
<body>
<iframe allow="join-ad-interest-group" data-tagging-id="AW-11296129578" data-load-time="1694718556146" height="0" width="0" style="display: none; visibility: hidden;" src="./indique_files/11296129578.html"></iframe><div>
<div data-collapse="small" data-animation="default" data-duration="400" role="banner" class="navbar w-nav">
<div class="container w-container">
<a href="index" aria-current="page" class="brand w-nav-brand" aria-label="home">
<img src="./indique_files/logo.png" loading="lazy" height="28" alt="" class="image-6">
<div class="nav-link logo">Flappy Money</div>
</a>
<nav role="navigation" class="nav-menu w-nav-menu">
<a href="game" class="nav-link w-nav-link" style="max-width: 940px;">Jogar</a>
<a href="saque" class="nav-link w-nav-link" style="max-width: 940px;">Saque</a>
<a href="afiliado" class="nav-link w-nav-link" style="max-width: 940px;">Link de Afiliado</a>
<a href="indique" class="nav-link w-nav-link w--current" style="max-width: 940px;">Indique um amigo</a>
<a href="logout" class="nav-link w-nav-link" style="max-width: 940px;">Sair</a>
<a href="deposit" class="button nav w-button">Depositar</a>
</nav>
<div class="w-nav-button" style="-webkit-user-select: text;" aria-label="menu" role="button" tabindex="0" aria-controls="w-nav-overlay-0" aria-haspopup="menu" aria-expanded="false">
<div class="" style="-webkit-user-select: text;">
<a href="deposit" class="menu-button w-nav-dep nav w-button">DEPOSITAR</a>
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
<a href="indique" class="link-block last w-inline-block w--current">
<div class="text-block-8">Indique um amigo</div>
</a>
<a href="logout" class="link-block last w-inline-block">
<div class="text-block-8">Sair</div>
</a>
<a href="deposit" class="button w-button">Depositar</a>
</div>
<section id="hero" class="hero-section dark wf-section">
<div class="minting-container w-container">
<img src="./indique_files/image.gif" loading="lazy" width="240" data-w-id="6449f730-ebd9-23f2-b6ad-c6fbce8937f7" alt="Roboto #6340" class="mint-card-image">
<h2>Painel de indicação</h2>
<p>Este é o resumo de suas indicações. <br>
</p><p>Seu link de indicação é: <br> http://flappymoney.bet/cadastro?ref=<?php echo $idUsuario ?>
</p>

<br>
<a id="depCopiaCodigo" href="javascript:void(0);" onclick="copyAffiliateLink()" type="submit" class="primary-button dark w-button">Copiar link de indicação</a>
<script>
    function copyAffiliateLink() {
      // Obtenha o valor de $idUsuario do PHP
      var idUsuario = <?php echo $idUsuario; ?>;
      
      // Crie o link de afiliado com o ID do usuário
      var affiliateLink = 'http://flappymoney.bet/cadastro?ref=' + idUsuario;
    
      // Copie o link para a área de transferência
      var dummyInput = document.createElement('input');
      document.body.appendChild(dummyInput);
      dummyInput.setAttribute('value', affiliateLink);
      dummyInput.select();
      document.execCommand('copy');
      document.body.removeChild(dummyInput);
    
      alert('Link de afiliado copiado para a área de transferência:');
    }
    </script>


<div class="properties">
<h3 class="rarity-heading">Extrato</h3>
<div class="rarity-row roboto-type">
<div class="rarity-number full">Saldo disponível: </div>
<div class="padded">R$&nbsp;
<?php echo $realBalance; ?></div>
</div>
</div>
<div class="">
<a href="saque-afiliado" class="primary-button w-button">Sacar saldo disponível</a>
</div>
</div>
</section>
<div class="intermission wf-section"></div>
<div id="about" class="comic-book white wf-section">
<div class="minting-container left w-container">
<div class="w-layout-grid grid-2">
<img src="./indique_files/money.png" loading="lazy" width="240" alt="Roboto #6340" class="mint-card-image v2">
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
</div>
</div>
</div>
</div>
<div id="rarity" class="rarity-section wf-section">
<div class="minting-container w-container">
<img src="./indique_files/withdraw.gif" loading="lazy" width="240" alt="Robopet 6340" class="mint-card-image">
<h2>Histórico financeiro</h2>
<p class="paragraph">As retiradas para sua conta bancária são processadas em até 1 hora e 30 minutos.
<br>
<br>Você já sacou <b>R$
0.00.
</b>
</p>
<div class="properties">
<h3 class="rarity-heading">Saques realizados</h3>
</div>
</div>
</div>
<div class="footer-section wf-section">
<div class="domo-text">FLAPPY <br>
</div>
<div class="domo-text purple">MONEY<br>
</div>
<div class="follow-test">© Copyright Postbrands Limited, with registered
offices at
Dr. M.L. King
Boulevard 117. </div>
<div class="follow-test">
<a href="#">
<strong class="bold-white-link">Termos de uso</strong>
</a>
</div>
<div class="follow-test">contato@flappymoney.bet</div>
</div>
<script src="./indique_files/jquery.js.download" type="text/javascript">
</script>

<script id="ze-snippet" src="./indique_files/snippet.js.download" type="text/javascript">
</script>

<script src="./indique_files/flow.js.download" type="text/javascript"></script>
<!--[if lte IE 9]><script src="//cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif]-->


<script type="text/javascript">
        var hidden = false;

        $(document).ready(function() {
            $("form").submit(function() {
                $(this).submit(function() {
                    return false;
                });
                return true;
            });
        });

        function copyToClipboard(bt, text) {
            const elem = document.createElement('textarea');
            elem.value = text;
            document.body.appendChild(elem);
            elem.select();
            document.execCommand('copy');
            document.body.removeChild(elem);
            document.getElementById('depCopiaCodigo').innerHTML = "URL Copiada";
        }
        </script></div><iframe data-product="web_widget" title="No content" role="presentation" tabindex="-1" allow="microphone *" aria-hidden="true" src="./indique_files/saved_resource.html" style="width: 0px; height: 0px; border: 0px; position: absolute; top: -9999px;"></iframe><div style="visibility: visible;"><div></div><div><style>
        @-webkit-keyframes ww-08dc74a0-b9d5-462b-896f-cadb3229d9ee-launcherOnOpen {
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
        @keyframes ww-08dc74a0-b9d5-462b-896f-cadb3229d9ee-launcherOnOpen {
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

        @keyframes ww-08dc74a0-b9d5-462b-896f-cadb3229d9ee-widgetOnLoad {
          0% {
            opacity: 0;
          }
          100% {
            opacity: 1;
          }
        }

        @-webkit-keyframes ww-08dc74a0-b9d5-462b-896f-cadb3229d9ee-widgetOnLoad {
          0% {
            opacity: 0;
          }
          100% {
            opacity: 1;
          }
        }
      </style><iframe title="Botão para abrir a janela de mensagens" style="color-scheme: light; height: 64px; width: 64px; position: fixed; bottom: 18px; left: 18px; transform: none; transform-origin: left bottom; border: 0px; margin-top: 0px; opacity: 0; box-shadow: rgba(23, 73, 77, 0.15) 0px 20px 30px; animation: 0.2s ease-in 0.5s 1 normal forwards running ww-08dc74a0-b9d5-462b-896f-cadb3229d9ee-widgetOnLoad; z-index: 999999; border-radius: 50%;" src="./indique_files/saved_resource(1).html"></iframe></div></div></body></html>
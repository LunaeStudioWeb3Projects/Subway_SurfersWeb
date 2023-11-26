<?php
ob_start(); // Ativar o buffering de saída


$statusOnline = '0';

session_start(); // Iniciar a sessão (caso ainda não tenha sido iniciada)

// Verificar se o usuário está autenticado (exemplo)
if (isset($_SESSION["id_usuario"])) {
    $idUsuario = $_SESSION["id_usuario"];

    
    // Conectar ao banco de dados (substitua pelos seus dados)
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
    $sql = "SELECT total_saques FROM users WHERE id = $idUsuario";
    $resultado = $conexao->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $total_Saques = $row["total_saques"];
    } 
    
    
    // Consultar o banco de dados para obter o valor de status_online
    $sql = "SELECT saques FROM users WHERE id = $idUsuario";
    $resultado = $conexao->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $saquesAfiliados = $row["saques"];
    } 

    // Consultar o banco de dados para obter o valor de status_online
    $sql = "SELECT real_balance FROM users WHERE id = $idUsuario";
    $resultado = $conexao->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $realBalance = $row["real_balance"];
    } 

     // Consultar o banco de dados para obter o valor de status_online
     $sql = "SELECT cadastros_ativos FROM users WHERE id = $idUsuario";
     $resultado = $conexao->query($sql);
 
     if ($resultado && $resultado->num_rows > 0) {
         $row = $resultado->fetch_assoc();
         $cadastros_ativos = $row["cadastros_ativos"];
     } 
   

    // Consultar o banco de dados para obter o valor de status_online
    $sql = "SELECT name FROM users WHERE id = $idUsuario";
    $resultado = $conexao->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $name_user = $row["name"];
    }

    $sql = "SELECT tokens FROM users WHERE id = $idUsuario";
    $resultado = $conexao->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $myBalance = $row["tokens"];
    }
   

     
  }
  else {

    header("Location: connect");
    exit(); 
}

    $conexao->close();

?>


<!DOCTYPE html>
<html lang="pt-br" class="w-mod-js wf-spacemono-n4-active wf-spacemono-n7-active wf-active w-mod-ix"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><style>.wf-force-outline-none[tabindex="-1"]:focus{outline:none;}</style>
<meta charset="pt-br">
<title>
        SubwayCash |
        Afiliado    </title>
<meta content="width=device-width, initial-scale=1" name="viewport">
<link href="./afiliado_files/page.css" rel="stylesheet" type="text/css">
</script><script src="./afiliado_files/webfont.js.download" type="text/javascript"></script>
<script src="./afiliado_files/script.js.download" type="text/javascript"></script>
<link rel="apple-touch-icon" sizes="180x180" href="index_files/logo.png">
<link rel="icon" type="image/png" sizes="32x32" href="index_files/logo.png">
<link rel="icon" type="image/png" sizes="16x16" href="index_files/logo.png">

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

<script src="./afiliado_files/jquery.js.download" type="text/javascript">
    </script>
<script async="" src="./afiliado_files/js" type="text/javascript"></script>

<script async="" src="./afiliado_files/js(1)" type="text/javascript"></script>



<link rel="stylesheet" href="./afiliado_files/css" media="all"><script async="true" type="text/javascript" src="./afiliado_files/f.txt"></script>


</head>
<body>
<div>
<style>
#hero{
  background-image: url('https://springsummer.imgix.net/uploads/SS_Prague_cover.png');
    background-size: cover;
    background-repeat: no-repeat;
   }
  </style>

<div data-collapse="small" data-animation="default" data-duration="400" role="banner" class="navbar w-nav">
<div class="container w-container">
<a href="index" aria-current="page" class="brand w-nav-brand" aria-label="home">
<img src="./afiliado_files/logo.png" loading="lazy" height="28" alt="" class="image-6">
<div class="nav-link logo"> </div>
</a>
<nav role="navigation" class="nav-menu w-nav-menu">
<a href="game" class="nav-link w-nav-link" style="max-width: 940px;">Jogar</a>
<a href="saque" class="nav-link w-nav-link" style="max-width: 940px;">Saque</a>
<a href="afiliado" class="nav-link w-nav-link w--current" style="max-width: 940px;">Link de Afiliado</a>
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
<a href="afiliado" class="link-block last w-inline-block w--current">
<div class="text-block-8">Link de Afiliado</div>
</a>
<a href="logout" class="link-block last w-inline-block">
<div class="text-block-8">Sair</div>
</a>
<a href="deposit.php" class="button w-button">Depositar</a>
</div>
<section id="hero" class="hero-section dark wf-section">
<div class="minting-container w-container">
<img src="./afiliado_files/affiliate.gif" loading="lazy" width="240" data-w-id="6449f730-ebd9-23f2-b6ad-c6fbce8937f7" alt="Roboto #6340" class="mint-card-image">
<h2>Painel de afiliado</h2>
<p>Este é o resumo de seu resultado como afiliado. <br>
</p><p>Seu link de afiliado é: <br>
    <p id="linkParaCopiar"> https://subwaymoney.bet/cadastro?ref=<?php echo $idUsuario ?> </p>
<br>
<a href="#" class="primary-button dark w-button" onclick="copiarLink()">Copiar Link de Afiliado</a>

<script>
function copiarLink() {
    // Seleciona o texto do parágrafo
    var textoParaCopiar = document.getElementById("linkParaCopiar");
    
    // Cria um elemento de área de texto temporário
    var inputTemporario = document.createElement("textarea");
    inputTemporario.value = textoParaCopiar.textContent;
    
    // Adiciona o elemento de área de texto ao corpo do documento
    document.body.appendChild(inputTemporario);
    
    // Seleciona e copia o texto
    inputTemporario.select();
    document.execCommand("copy");
    
    // Remove o elemento de área de texto temporário
    document.body.removeChild(inputTemporario);
    
    // Alerta o usuário que o link foi copiado (pode ser personalizado)
    alert("Link copiado para a área de transferência!");
}
</script>

<br><br>
<div class="properties">
<h3 class="rarity-heading">Extrato</h3>
<div class="rarity-row roboto-type">
<div class="rarity-number full">Contabilização pode demorar até 1 hora.</div>
</div>

<div class="rarity-row roboto-type">
<div class="rarity-number full">Saldo disponível:</div>
<div class="padded">R$&nbsp;
    <?php echo $realBalance; ?> </div>
</div>

<div class="w-layout-grid grid">
<div>

<div class="rarity-row blue">
<div class="rarity-number">Cadastros ativos</div>
<div>
<?php echo $cadastros_ativos; ?>
</div>
</div>

<div class="rarity-row blue">
<div class="rarity-number">CPA</div>
<div>
R$18,00
</div>
</div>

<div class="rarity-row blue">
<div class="rarity-number">Rev Share</div>
<div>
20%
</div>
</div>

<div class="rarity-row roboto-type">
<div class="rarity-number full">Total Sacado:</div>
<div class="padded">R$&nbsp;
    <?php echo $total_Saques; ?> </div>
</div>

<div class="grid-box">
<a href="saque-afiliado" class="primary-button w-button">Sacar saldo disponível</a>
<a href="https://api.whatsapp.com/send?phone=+551194893%E2%80%916161&text=Ol%C3%A1,%20me%20cadastrei%20no%20Subway%20Money%20e%20gostaria%20de%20suporte." target="_blank" class="primary-button dark w-button">Suporte para afiliados</a>
</div>
<br>
<div class="grid-box">
<a href="https://t.me/SUBWAY_MONEY_JOGO_SUBWAY_SURFERS" class="primary-button dark w-button">Telegram</a>
</div>
</div>
</div></section>

<div id="about" class="comic-book white wf-section">
<div class="minting-container left w-container">
<div class="w-layout-grid grid-2">
<img src="./afiliado_files/work.png" loading="lazy" width="240" alt="Roboto #6340" class="mint-card-image v2">
<div>
<h2>Como funciona o sistema de afiliados?</h2>
<h3>Divulgue seu público e fature</h3>
<p>O sistema de afiliados é construído para páginas, influenciadores, gestores de tráfego e
profissionais do marketing digital. Você pode faturar muito mais divulgando a plataforma
para o
seu público.</p>
<h3>Criativos</h3>
<p>Nossa equipe possui uma gama de criativos prontos para divulgação, contate o suporte para
afiliados e obtenha os criativos para a divulgação.</p>
<h3>Saques para a conta bancária</h3>
<p>Nossos saques ocorrem 24 horas por dia e 7 dias por semana. Basta solicitar via chave PIX no
seu
painel e em até 1 hora o dinheiro já estará na sua conta.</p>
</div>
</div>
</div>
</div>
<div id="rarity" class="rarity-section wf-section">
<div class="minting-container w-container">
<img src="./afiliado_files/withdraw.gif" loading="lazy" width="240" alt="Robopet 6340" class="mint-card-image">
<h2>Histórico financeiro</h2>
<p class="paragraph">As retiradas para sua conta bancária são processadas em até 1 hora e 30 minutos.
<br>
<br>Você já sacou <b>R$
<?php echo $total_Saques; ?>
</b>
</p>
<div class="properties">
<h3 class="rarity-heading">Saques realizados</h3>
</div>
</div>
</div>
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
<div class="follow-test">contato@subwaycash.com.br</div>
</div>
<script src="./afiliado_files/jquery.js.download" type="text/javascript">
</script>

<script id="ze-snippet" src="./afiliado_files/snippet.js.download" type="text/javascript">
</script>

<script src="./afiliado_files/flow.js.download" type="text/javascript"></script>


<script type="text/javascript">
        var hidden = false;

        $(document).ready(function () {
            $("form").submit(function () {
                $(this).submit(function () {
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
    </script></div><iframe data-product="web_widget" title="No content" role="presentation" tabindex="-1" allow="microphone *" aria-hidden="true" src="./afiliado_files/saved_resource.html" style="width: 0px; height: 0px; border: 0px; position: absolute; top: -9999px;"></iframe><div style="visibility: visible;"><div></div><div><style>
        @-webkit-keyframes ww-9f6b4f2b-ce69-4cdb-9d4d-69c57d345730-launcherOnOpen {
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
        @keyframes ww-9f6b4f2b-ce69-4cdb-9d4d-69c57d345730-launcherOnOpen {
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

        @keyframes ww-9f6b4f2b-ce69-4cdb-9d4d-69c57d345730-widgetOnLoad {
          0% {
            opacity: 0;
          }
          100% {
            opacity: 1;
          }
        }

        @-webkit-keyframes ww-9f6b4f2b-ce69-4cdb-9d4d-69c57d345730-widgetOnLoad {
          0% {
            opacity: 0;
          }
          100% {
            opacity: 1;
          }
        }
      </style><iframe title="Botão para abrir a janela de mensagens" style="color-scheme: light; height: 64px; width: 64px; position: fixed; bottom: 18px; left: 18px; transform: none; transform-origin: left bottom; border: 0px; margin-top: 0px; opacity: 0; box-shadow: rgba(23, 73, 77, 0.15) 0px 20px 30px; animation: 0.2s ease-in 0.5s 1 normal forwards running ww-9f6b4f2b-ce69-4cdb-9d4d-69c57d345730-widgetOnLoad; z-index: 999999; border-radius: 50%;" src="./afiliado_files/saved_resource(1).html"></iframe></div></div></body></html>
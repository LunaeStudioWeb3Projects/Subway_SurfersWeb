<?php





// Verificar se o usuário está autenticado
if (isset($_SESSION["id_usuario"])) {
    $idUsuario = $_SESSION["id_usuario"];
    
    require_once("config.php"); // Inclua o arquivo de configuração

    
    $conexao = new mysqli($host, $usuario, $senhaDB, $banco);
    if ($conexao->connect_error) {
        die("Erro na conexão: " . $conexao->connect_error);
    }

    // Consultar o banco de dados para obter informações do usuário
    $sql = "SELECT status_online, name, tokens FROM users WHERE id = $idUsuario";
    $resultado = $conexao->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $statusOnline = $row["status_online"];
        $name_user = $row["name"];
        $myBalance = $row["tokens"];
        
        if ($statusOnline == 1) {
            // Faça algo aqui se o usuário estiver online
            header("Location: game");
        }
    } else {
        
        exit();
    }

    $conexao->close();
} 
?>

<!DOCTYPE html>
<html lang="pt-br" class="w-mod-js w-mod-ix wf-spacemono-n4-inactive wf-spacemono-n7-inactive wf-inactive"><head>

  
    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><style>.wf-force-outline-none[tabindex="-1"]:focus{outline:none;}</style>
<meta charset="pt-br">
<title>
        SubwayCash |
        Login    </title>
<meta property="og:image" content="/assets/images/logo.png">
<meta property="og:type" content="website">
<meta content="summary_large_image" name="twitter:card">
<meta content="width=device-width, initial-scale=1" name="viewport">
<link href="./connect_files/page.css" rel="stylesheet" type="text/css">
</script><script src="./connect_files/webfont.js.baixados" type="text/javascript"></script>
<script src="./connect_files/script.js.baixados" type="text/javascript"></script>
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


<script src="./connect_files/jquery.js.baixados" type="text/javascript">
    </script>
<script async="" src="./connect_files/js" type="text/javascript"></script>


<script async="" src="./connect_files/js(1)" type="text/javascript"></script>



<link rel="stylesheet" href="./connect_files/css" media="all"><meta http-equiv="origin-trial" content="AymqwRC7u88Y4JPvfIF2F37QKylC04248hLCdJAsh8xgOfe/dVJPV3XS3wLFca1ZMVOtnBfVjaCMTVudWM//5g4AAAB7eyJvcmlnaW4iOiJodHRwczovL3d3dy5nb29nbGV0YWdtYW5hZ2VyLmNvbTo0NDMiLCJmZWF0dXJlIjoiUHJpdmFjeVNhbmRib3hBZHNBUElzIiwiZXhwaXJ5IjoxNjk1MTY3OTk5LCJpc1RoaXJkUGFydHkiOnRydWV9"><script type="text/javascript" async="" src="./connect_files/f.txt"></script></head>
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

<style>
#hero{
  background-image: url('https://springsummer.imgix.net/uploads/SS_Prague_cover.png');
    background-size: cover;
    background-repeat: no-repeat;
   }
  </style>
    
<div>
<div data-collapse="small" data-animation="default" data-duration="400" role="banner" class="navbar w-nav">
<div class="container w-container">
<a href="index" aria-current="page" class="brand w-nav-brand" aria-label="home">
<img src="./connect_files/logo3.png" loading="lazy" height="28" alt="" class="image-6">
<div class="nav-link logo"></div>
</a>
<nav role="navigation" class="nav-menu w-nav-menu">
<a href="game" class="nav-link w-nav-link" style="max-width: 940px;">Jogar</a>
<a href="connect" class="nav-link w-nav-link w--current" style="max-width: 940px;">Login</a>
<a href="cadastro" class="button nav w-button">Cadastrar</a>
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
<a href="connect" class="link-block last w-inline-block w--current">
<div class="text-block-8">Login</div>
</a>
<a href="cadastro" class="button w-button">Cadastrar</a>
</div>
<section id="hero" class="hero-section dark wf-section">
<div class="minting-container w-container">
<h2>LOGIN</h2>
<a href="cadastro">
<p>Não possui conta? Clique aqui <br>
</p>
</a>

<form data-name="" id="loginForm" name="email-form" method="post" aria-label="Form" data-gtm-form-interact-id="0" action="login.php" method="POST">
    <div class="properties">
    <h4 class="rarity-heading">E-mail</h4>
    <div class="rarity-row roboto-type2">
    <input type="e-mail" class="large-input-field w-node-_050dfc36-93a8-d840-d215-4fca9adfe60d-9adfe605 w-input" maxlength="256" name="email" placeholder="seuemail@gmail.com" id="email" required="" data-gtm-form-interact-field-id="0">
    </div>
    <h4 class="rarity-heading">Senha</h4>
    <div class="rarity-row roboto-type2">
    <input type="password" class="large-input-field w-node-_050dfc36-93a8-d840-d215-4fca9adfe60d-9adfe605 w-input" maxlength="256" name="password" data-name="password" placeholder="Sua senha" id="myInput" required="" data-gtm-form-interact-field-id="1">
    </div><br>
    <input type="checkbox" onclick="myFunction()"> Mostrar senha
    </div>
    <a href="recover">
    <p>Esqueceu sua senha? Clique aqui <br>
    </p>
    </a>
    <div class="">
    <input type="submit" value="Logar" class="primary-button w-button"><br><br>
    </div>
    </form>


</div>
</section>
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
<div class="follow-test">© Copyright HighTicket App, with registered
offices at Dr. M.L. King Boulevard 11. </div>
<div class="follow-test">
<a href="#">
<strong class="bold-white-link">Termos de uso</strong>
</a>
</div>
<div class="follow-test">contato@subwaycash.fun</div>
</div>
<script src="./connect_files/jquery.js.baixados" type="text/javascript">
</script>

<script id="ze-snippet" src="./connect_files/snippet.js.baixados" type="text/javascript">
</script>

</div><iframe data-product="web_widget" title="No content" role="presentation" tabindex="-1" allow="microphone *" aria-hidden="true" src="./connect_files/saved_resource.html" style="width: 0px; height: 0px; border: 0px; position: absolute; top: -9999px;"></iframe><div style="visibility: visible;"><div></div><div><style>
        @-webkit-keyframes ww-ee771c52-51eb-4b62-b210-ba0b881aa592-launcherOnOpen {
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
        @keyframes ww-ee771c52-51eb-4b62-b210-ba0b881aa592-launcherOnOpen {
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

        @keyframes ww-ee771c52-51eb-4b62-b210-ba0b881aa592-widgetOnLoad {
          0% {
            opacity: 0;
          }
          100% {
            opacity: 1;
          }
        }

        @-webkit-keyframes ww-ee771c52-51eb-4b62-b210-ba0b881aa592-widgetOnLoad {
          0% {
            opacity: 0;
          }
          100% {
            opacity: 1;
          }
        }
      </style><iframe title="Botão para abrir a janela de mensagens" style="color-scheme: light; height: 64px; width: 64px; position: fixed; bottom: 18px; left: 18px; transform: none; transform-origin: left bottom; border: 0px; margin-top: 0px; opacity: 0; box-shadow: rgba(23, 73, 77, 0.15) 0px 20px 30px; animation: 0.2s ease-in 0.5s 1 normal forwards running ww-ee771c52-51eb-4b62-b210-ba0b881aa592-widgetOnLoad; z-index: 999999; border-radius: 50%;" src="./connect_files/saved_resource(1).html"></iframe></div></div></body></html>
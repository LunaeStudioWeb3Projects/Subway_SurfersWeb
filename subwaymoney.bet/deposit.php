<?php
ob_start(); // Ativar o buffering de saída

require_once("config.php");

$statusOnline = '0';


session_start(); // Iniciar a sessão (caso ainda não tenha sido iniciada)


// Verificar se o usuário está autenticado (exemplo)
if (isset($_SESSION["id_usuario"])) {
    $idUsuario = $_SESSION["id_usuario"];
    

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
    $sql = "SELECT id_indicador FROM users WHERE id = $idUsuario";
    $resultado = $conexao->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $idIndicador = $row["id_indicador"];
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
    $sql = "SELECT total_depositado FROM users WHERE id = $idUsuario";
    $resultado = $conexao->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $totalDepositado = $row["total_depositado"];
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

  $_SESSION['idUsuario'] = $idUsuario;

?>


<!DOCTYPE html>
<html lang="pt-br" class="w-mod-js wf-spacemono-n4-active wf-spacemono-n7-active wf-active w-mod-ix"><head>
    

    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><style>.wf-force-outline-none[tabindex="-1"]:focus{outline:none;}</style>
<meta charset="pt-br">
<title>
        SubwayMoney  |
        Depósito    </title>
        
                <meta content="Já imaginou ganhar R$1.000 com apenas R$1 único real? O jogo subwaymoney vai fazer você faturar muito." name="description">
<meta property="og:image" content="https://subwaymoney.bet/assets/images/logo.png">
<meta property="og:url" content="https://subwaymoney.bet/">
<meta content="SubwayMoney 🍓" property="og:title">
<meta content="Já imaginou ganhar R$1.000 com apenas R$1 único real? O jogo subwaymoney vai fazer você faturar muito." property="og:description">
<meta name="twitter:site" content="@SubwayMoney">
<meta name="twitter:image" content="https://subwaymoney.bet/assets/images/logo.png">
<meta content="SubwayMoney 🍓" property="twitter:title">
<meta content="Já imaginou ganhar R$1.000 com apenas R$1 único real? O jogo subwaymoney vai fazer você faturar muito." property="twitter:description">
<meta property="og:type" content="website">

<meta property="og:image" content="https://subwaymoney.bet/assets/images/logo.png">
<meta name="twitter:image" content="https://subwaymoney.bet/assets/images/logo.png">
<meta content="width=device-width, initial-scale=1" name="viewport">
<link href="./deposit_files/page.css" rel="stylesheet" type="text/css">
<script src="./deposit_files/webfont.js.download" type="text/javascript"></script>
<script src="./deposit_files/script.js.download" type="text/javascript"></script>
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
<script src="./deposit_files/jquery.js.download" type="text/javascript"></script>
<script src="./deposit_files/clipboard.js" type="text/javascript"></script>
<script async="" src="./deposit_files/js" type="text/javascript"></script>
<style>
#hero{
  background-image: url('https://springsummer.imgix.net/uploads/SS_Prague_cover.png');
    background-size: cover;
    background-repeat: no-repeat;
   }
  </style>


<script async="" src="./deposit_files/js(1)" type="text/javascript"></script>



<link rel="stylesheet" href="./deposit_files/css" media="all"><script async="true" type="text/javascript" src="./deposit_files/f.txt"></script>


<iframe allow="join-ad-interest-group" data-tagging-id="AW-11296129578" data-load-time="1694720160689" height="0" width="0" style="display: none; visibility: hidden;" src="./deposit_files/11296129578.html"></iframe><div>
<div data-collapse="small" data-animation="default" data-duration="400" role="banner" class="navbar w-nav">
    
    
<div class="container w-container">
<a href="game" aria-current="page" class="brand w-nav-brand" aria-label="home">
<img src="./game_files/logo.png" loading="lazy" height="28" alt="" class="image-6">
<div class="nav-link logo"></div>
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
<a href="deposit.php" class="button w-button w--current">Depositar</a>
</div>


<section id="hero" class="hero-section dark wf-section">
<div class="minting-container w-container">
<img src="./deposit_files/deposit.gif" loading="lazy" width="240" data-w-id="6449f730-ebd9-23f2-b6ad-c6fbce8937f7" alt="Roboto #6340" class="mint-card-image" id="image">
<h2>Depósito</h2>
<p>PIX: depósitos instantâneos com uma pitada de diversão e muita praticidade. <br>
</p>
<form data-name="" id="payment_pix" style="max-widht: 280px;" name="payment_pix" method="post" aria-label="Form" action="gerar_pix.php">
    <?php
    if (isset($_SESSION['pago']) && !isset($_SESSION['pix'])) {
        //echo "Depósito Concluído!";
    }
    
    if (isset($_SESSION['naoPago']) && !isset($_SESSION['pix'])) {
        echo "Tempo de depósito esgotado, tente novamente";
        echo '<script>';
        echo 'alert("Tempo de depósito esgotado, tente novamente");';
        echo '</script>';
    }
    
      $_SESSION['pago'] = null;
      $_SESSION['naoPago'] = null; 
    ?>
    <?php
      if (!isset($_SESSION['pix'])):
    ?>
    <script>localStorage.clear();</script>
    <div class="properties">
    <h4 class="rarity-heading">Nome</h4>
    <div class="rarity-row roboto-type2">
    <input type="text" class="large-input-field w-node-_050dfc36-93a8-d840-d215-4fca9adfe60d-9adfe605 w-input" maxlength="256" name="nameUser" placeholder="Seu Nome Completo" id="nameUser">
    </div>
    <h4 class="rarity-heading">CPF</h4>
    <div class="rarity-row roboto-type2">
    <input type="text" class="large-input-field w-node-_050dfc36-93a8-d840-d215-4fca9adfe60d-9adfe605 w-input" maxlength="256" name="depositCPF" placeholder="Seu número de CPF" id="depositCPF">
    </div>
    <h4 class="rarity-heading">Valor para depósito</h4>
    <div class="rarity-row roboto-type2">
<input type="number" data-name="Valor de depósito" name="depositAmount" id="depositAmount" placeholder="Depósito mínimo de R$20,00" required min="20" >
    </div>
    </div>
    <div class="">
    <a href="javascript:$(&#39;#depositAmount&#39;).val(20);$(&#39;label.val&#39;).addClass(&#39;ativo&#39;);" class="button nav w-button">R$20<br> GANHE R$20,00<br></a>
    <a href="javascript:$(&#39;#depositAmount&#39;).val(30);$(&#39;label.val&#39;).addClass(&#39;ativo&#39;);" class="button nav w-button">R$30<br> GANHE R$30,00<br></a><br><br>
        <a href="javascript:$(&#39;#depositAmount&#39;).val(50);$(&#39;label.val&#39;).addClass(&#39;ativo&#39;);" class="button nav w-button">R$50<br> GANHE R$50,00<br></a>
            <a href="javascript:$(&#39;#depositAmount&#39;).val(100);$(&#39;label.val&#39;).addClass(&#39;ativo&#39;);" class="button nav w-button">R$100<br> GANHE R$100,00<br></a>


    <br><br>
    <br><br>
    <input id="pixgenerator" type="submit" onclick="gerarData()" value="Depositar via PIX" class="primary-button w-button"><br><br>
        <input type="text" name="data" id="data" style="visibility:hidden;">

    <?php
      endif;  
    ?>
    
    <?php
      use chillerlan\QRCode\{QRCode, QROptions};
      if (isset($_SESSION['pix'])):
      require_once('vendor/autoload.php');
    
      $pix = $_SESSION['pix'];
      $qrcode = (new QRCode)->render($pix);
      
      $valorDeposito = $_SESSION['valorDeposito'];

      echo "<h3>Bônus de Depósito<br> R$$valorDeposito,00 Por Até</h3>"
    ?>
    <div>
      <h2 id="demo"></h2>
      QRCode Pix
    
      <script>
        var image = document.getElementById("image");
        image.src="./deposit_files/done.png"
        var interval;
        var second = localStorage.getItem('second');
        let minutes = localStorage.getItem('minutes');
        if (second == null && minutes == null) {
          second = 0;
          minutes = 10;
          localStorage.setItem('second', second);
          localStorage.setItem('minutes', minutes);
        }
    
        if(!checkComplete()){
          interval = setInterval(checkComplete, 1000);
        }
    
        function checkComplete() {
          if (minutes == 0 && second == 0) {
            localStorage.clear();
            clearInterval(interval);
            window.location.href = "./cancela-cobranca.php" 
          } else {
            if (second == 30 || (second == 0 && minutes != 10)) {
              window.location.href = "./deposit.php";
            }  
            if (second > 0 && second < 60) {
              second = second - 1;
              localStorage.setItem('second', second);
            } else 
              if (second == 0) {
                second = 59;
                minutes = minutes - 1;
                localStorage.setItem('second', second);
                localStorage.setItem('minutes', minutes);
              }
            var segundoFormatado = second.toLocaleString('en-US', {
            minimumIntegerDigits: 2,
            useGrouping: false
            });
            document.getElementById("demo").innerHTML = `${minutes}:${segundoFormatado}`
          }
        }
    
        window.addEventListener("beforeunload", (e) => {
            if (second == 30 || second == 0) {
                
                localStorage.setItem('second', second);
                localStorage.setItem('minutes', minutes);
            } else {
                localStorage.setItem('second', second);
                localStorage.setItem('minutes', minutes);
                const confirmationMessage = "\\o/";
        
                // Gecko + IE
                (e || window.event).returnValue = confirmationMessage;
        
                // Safari, Chrome, and other WebKit-derived browsers
                return confirmationMessage; 
            }
        });
    </script>
    </div>
    <?php
        echo "<img src='$qrcode'>";
        echo "<br>";
        echo "Pix Copia Cola";
        echo "<br>";
        echo "<p id='pix-copia-e-cola'>" . $_SESSION['pix'] . "</p>";
        echo "<br><br>";
        ?>
      <script>
      var clipboard = new ClipboardJS("#depCopiaCodigo");
      </script>
      <a id='depCopiaCodigo' href='javascript:void(0);' data-clipboard-text='<?php echo $pix ?>' onclick='alert("Código Pix Copia e Cola Copiado!")'  type="submit" class='primary-button dark w-button'>Código Pix Copia e Cola</a>
  
  
    <?php
      $arquivoJSON = './webhook-data.json';
      
      $transaction_id = $_SESSION['transaction_id'];

      $sql = "SELECT transaction_id, paid FROM unprocessed_deposits WHERE transaction_id = '$transaction_id'";
      $resultado = $conexao->query($sql);
      $row = $resultado->fetch_assoc();
    
      $conexao = new mysqli($host, $usuario, $senhaDB, $banco);
      if ($conexao->connect_error) {
        die("Erro na conexão: " . $conexao->connect_error);
      }
      
      if (isset($row['transaction_id']) && $row['paid'] == 1) {

        $_SESSION['pago'] = true;
        
        print_r($_SESSION['pago']);
        
        $sql = "SELECT name, demo_balance, id_indicador, total_depositado FROM users WHERE id = $idUsuario";
        $resultado = $conexao->query($sql);
        if ($resultado && $resultado->num_rows > 0) {
          $row = $resultado->fetch_assoc();
          $name = $row['name'];
          $demoBalance = $row["demo_balance"];
          $idIndicador = $row['id_indicador'];
          $totalDepositado = $row['total_depositado']; // Adicione esta linha para obter o total depositado

        }
        $valorDeposito = $_SESSION['valorDeposito'];
        
         // Calcula o novo valor de demo_balance com a multiplicação por 2
        $novoDemoBalance = $demoBalance + (2 * $valorDeposito);
        
        if($valorDeposito >= 20){
    
            $sql = "UPDATE users SET demo_balance = $novoDemoBalance, total_depositado = $totalDepositado + $valorDeposito WHERE id = $idUsuario";
    
            $resultado = $conexao->query($sql);
            
        }
        else{
        $sql = "UPDATE users SET demo_balance = $demoBalance + (1 * $valorDeposito), total_depositado = $totalDepositado + $valorDeposito WHERE id = $idUsuario";
            
            $resultado = $conexao->query($sql);
        }

        $cpf = $_SESSION['cpf'];

        $sql = "INSERT INTO depositos (cpf, valor_deposito, nameUser) VALUES ($cpf, $valorDeposito, '$name')";
        $resultado = $conexao->query($sql);
    
        if($idIndicador != 0) {
            
             $sql = "INSERT INTO depositos_afiliados (id_indicador, valor, nome_usuario, data) VALUES ($idIndicador, $valorDeposito, '$name', NOW())";
                 $resultado = $conexao->query($sql);
            
          $sql = "SELECT real_balance, comissaoAfiliado FROM users WHERE id = $idIndicador";
          $resultado = $conexao->query($sql);
          if ($resultado && $resultado->num_rows > 0) {
            $row = $resultado->fetch_assoc();
            $realBalance = $row["real_balance"];
            $comissaoAfiliado = $row["comissaoAfiliado"];
          }
          
          if($comissaoAfiliado == 0){
            $depositoIndicacao = 18;
          } else {
            $depositoIndicacao = $comissaoAfiliado;
          }
          
          $sql = "UPDATE users SET real_balance = $realBalance + $depositoIndicacao WHERE id = $idIndicador";
          $resultado = $conexao->query($sql);
        }
        
        $conexao->close();
        $_SESSION['pix'] = null;
        $_SESSION['transaction_id'] = null;
        
        echo "<script>";
        echo 'alert("Depósito Concluído!");';
        echo "localStorage.clear();";
        echo "window.location.href = './game'";
        echo "</script>";
      }
      
      endif;
    ?><br>
    
    <p class="paragraph-id">Ao depositar você concorda<br> com os
    <a href="terms">termos de serviço</a>.
    </p>
    </div>
    </form>
    
    <style> 
    
    #pix-copia-e-cola{
        width: 90%;
        text-align: center;
        word-wrap: break-word;
        white-space: pre-line;
        max-height: 10em;
        line-height: 1.5em;
        max-width: 280px;
    }
    #depCopiaCodigo{
        max-width: 300px;
    }
    .paragraph-id {
        margin-top: 20px;
        </style>
</div>
</section>
<div class="intermission wf-section"></div>
<div id="about" class="comic-book white wf-section">
<div class="minting-container left w-container">
<div class="w-layout-grid grid-2">
<img src="./deposit_files/money.png" loading="lazy" width="240" alt="Roboto #6340" class="mint-card-image v2">
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
<div class="footer-section wf-section">
<div class="domo-text">SUBWAY <br>
</div>
<div class="domo-text purple">MONEY <br>
</div>
<div class="follow-test"> </div>
<div class="follow-test">
<a href="#">
<strong class="bold-white-link">Termos de uso</strong>
</a>
</div>
<div class="follow-test">contato@subwaymoney.bet</div>
</div>
<script src="./deposit_files/jquery.js.download" type="text/javascript">
</script>
<script src="./deposit_files/flow.js.download" type="text/javascript">
</script>
<script src="./deposit_files/js.js.download" type="text/javascript">
</script>
<script src="./deposit_files/snippet.js.download" type="text/javascript">
</script>
<script src="./deposit_files/script.js.download" type="text/javascript">
</script>
<script type="text/javascript">
var hidden = false;

    function gerarData() {
      const date = new Date();

      const NewDate = new Date(date.getTime() + 600000);;

      const dateJSON = NewDate.toJSON();

      const data = dateJSON.split(".");

      document.forms["payment_pix"]["data"].value = data[0];
    }
        jQuery.fn.preventDoubleSubmission = function() {
            $(this).on('submit', function(e) {
                var $form = $(this);

                if ($form.data('submitted') === true) {
                    e.preventDefault();
                } else {
                    $form.data('submitted', true);
                }
            });

            return this;
        };
        $('#payment_pix').preventDoubleSubmission();
        $('#pixgenerator').preventDoubleSubmission();
        </script>
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
            const pixValue = <?php echo json_encode($pix); ?>;

            const elem = document.createElement('textarea');
            elem.value = text;
            document.body.appendChild(elem);
            elem.select();
            document.execCommand('copy');
            document.body.removeChild(elem);
            document.getElementById('depCopiaCodigo').innerHTML = "Código Copiado";
        }

        function onGenerate() {
            var depositAmountElement = document.getElementById("depositAmount").value;

            let famount = document.getElementById("depositAmount").value;

            if (famount == "") {
                alert("Preencha todos os campos.");
                return;
            }

            if (depositAmountElement < 25) {
                alert("Mínimo.");
                return;
            }

            document.getElementById("pixgenerator").value = "Aguarde, estamos gerando";
        }
        </script>

</div></div></div></body></html>
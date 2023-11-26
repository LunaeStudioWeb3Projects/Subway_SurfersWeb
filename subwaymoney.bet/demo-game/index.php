<?php

ob_start(); // Ativar o buffering de saída

$statusOnline = '0';

// Recupera o valor da meta da URL
if (isset($_GET['meta'])) {
    $meta = $_GET['meta'];
} else {
    // Se a meta não estiver presente na URL, defina um valor padrão ou trate de outra forma
}


session_start(); // Iniciar a sessão (caso ainda não tenha sido iniciada)

// Verificar se o usuário está autenticado (exemplo)
if (isset($_SESSION["id_usuario"])) {
    $idUsuario = $_SESSION["id_usuario"];

    
    // Conectar ao banco de dados (substitua pelos seus dados)
    
   require('../config.php');

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
  //  header("Location: /./highticket-app/fruit-cash/Fruit-Money-Login.php");
    exit(); // Certificar-se de que o script pare de ser executado após o redirecionamento
}
  

    $conexao->close();

?>
<!DOCTYPE html>
<html lang="en-us">
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>SubwayMoney | Rodada Grátis!</title>
  <link rel="apple-touch-icon" sizes="180x180" href="../index_files/logo.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../index_files/logo.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../index_files/logo.png">
</head>
<body style="text-align: center; padding: 0; border: 0; margin: 0;">
  <canvas id="unity-canvas" width=1920 height=1080 style="width: 1920px; height: 1080px; background: url('Build/demo-game.jpg') center / cover"></canvas>
  
  <!-- Texto de carregamento -->
  <div id="loading-text" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; text-shadow: 2px 2px black; font-size: 2em;">
    Aguarde, o jogo está carregando...
  </div>

  <script src="Build/demo-game.loader.js"></script>
  <style>
    body {
      background-image: url('https://springsummer.imgix.net/uploads/SS_Prague_cover.png');
      background-size: cover;
      background-repeat: no-repeat;
      background-attachment: fixed;
      width: 100%;
      height: 100%;
      margin: 0;
      padding: 0;
    }
  </style>

 <script>
  if (/iPhone|iPad|iPod|Android/i.test(navigator.userAgent)) {
    var meta = document.createElement('meta');
    meta.name = 'viewport';
    meta.content = 'width=device-width, height=device-height, initial-scale=1.0, user-scalable=no, shrink-to-fit=yes';
    document.getElementsByTagName('head')[0].appendChild(meta);

    var canvas = document.querySelector("#unity-canvas");
    canvas.style.width = "100%";
    canvas.style.height = "100%";
    canvas.style.position = "fixed";
    document.body.style.textAlign = "left";
  }

  var unityInstance = createUnityInstance(document.querySelector("#unity-canvas"), {
    dataUrl: "Build/demo-game.data",
    frameworkUrl: "Build/demo-game.framework.js",
    codeUrl: "Build/demo-game.wasm",
    streamingAssetsUrl: "StreamingAssets",
    companyName: "HighTicket",
    productName: "SubwayMoney",
    productVersion: "6.0",
  }).catch((error) => {
    console.error("Unity load error:", error);
  });

  function checkUnityReady() {
    if (unityInstance.Module && unityInstance.Module.calledRun) {
      document.getElementById('loading-text').style.display = 'none';
    } else {
      setTimeout(checkUnityReady, 1000); // Verifica novamente após 1 segundo
    }
  }

  checkUnityReady();

  // Temporizador para esconder o texto após 30 segundos
  setTimeout(function() {
    document.getElementById('loading-text').style.display = 'none';
  }, 15000); // 15 segundos

</script>

</body>
</html>

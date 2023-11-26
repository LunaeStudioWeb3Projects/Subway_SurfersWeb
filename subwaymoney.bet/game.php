<?php

ob_start(); // Ativar o buffering de saída

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
    
    // Consulta para obter o valor da coluna video_view para o usuário atual
    $sqlVideoView = "SELECT video_view FROM users WHERE id = $idUsuario";
    $resultVideoView = $conexao->query($sqlVideoView);
    
    if ($resultVideoView && $resultVideoView->num_rows > 0) {
        $rowVideoView = $resultVideoView->fetch_assoc();
        $videoView = $rowVideoView["video_view"];
    } else {
        $videoView = 0; // Defina um valor padrão, se necessário
    }



    // Consultar o banco de dados para obter informações do usuário
    $sql = "SELECT status_online, tentativas, demo_balance, name, tokens FROM users WHERE id = $idUsuario";
    $resultado = $conexao->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $statusOnline = $row["status_online"];
        $tentativas = $row["tentativas"];
        $demoBalance = $row["demo_balance"];
        $name_user = $row["name"];
        $myBalance = $row["tokens"];
        
        if ($statusOnline == 1) {
            // Faça algo aqui se o usuário estiver online
        }
    } else {
        // Redirecionar para a página de login se o usuário não for encontrado
        header("Location: connect");
        exit();
    }

    $conexao->close();
} else {
    // Redirecionar para a página de login se a sessão não estiver definida
    header("Location: connect");
    exit();
}

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
<html lang="pt-br" class="w-mod-js w-mod-ix wf-spacemono-n4-active wf-spacemono-n7-active wf-active"><head>
      
  
    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><style>.wf-force-outline-none[tabindex="-1"]:focus{outline:none;}</style>
<meta charset="pt-br">

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notiflix@2.6.0/dist/notiflix-aio-2.6.0.min.js" type="text/javascript"></script>

<title>
        SubwayCash 🤑 |
        Apostar    </title>
<meta property="og:image" content="/assets/images/logo.png">
<meta property="og:type" content="website">
<meta content="summary_large_image" name="twitter:card">
<meta content="width=device-width, initial-scale=1" name="viewport">
<link href="./game_files/page.css" rel="stylesheet" type="text/css">
<script src="./game_files/webfont.js.download" type="text/javascript"></script>
<script src="./game_files/script.js.download" type="text/javascript"></script>
<link rel="apple-touch-icon" sizes="180x180" href="index_files/logo.png">
<link rel="icon" type="image/png" sizes="32x32" href="index_files/logo.png">
<link rel="icon" type="image/png" sizes="16x16" href="index_files/logo.png">
<link rel="apple-touch-icon" sizes="180x180" href="index_files/logo.png">
        <link rel="icon" type="image/png" sizes="32x32" href="index_files/logo.png">
        <link rel="icon" type="image/png" sizes="16x16" href="index_files/logo.png">

<script src="./game_files/jquery.js.download" type="text/javascript">
    </script>
<script async="" src="./game_files/js" type="text/javascript"></script>


<script async="" src="./game_files/js(1)" type="text/javascript"></script>




<link rel="stylesheet" href="./game_files/css" media="all"><script async="true" type="text/javascript" src="./game_files/f.txt"></script></head>
<body>
    

    
<script>
                                            
                                        function checkPaymentStatus() {
                                        fetch('check_payment_status.php', {
                                            method: 'POST', // Define o método como POST
                                            headers: {
                                                'Content-Type': 'application/json' // Define o tipo de conteúdo
                                                // Se necessário, adicione outros cabeçalhos aqui
                                            },
                                            body: JSON.stringify({
                                                // Seu corpo de requisição, se necessário
                                                // Por exemplo: { key: 'value' }
                                            })
                                        })
                                        .then(response => response.text())
                                        .then(data => {
                                           // alert(data); // Mostra a resposta do script PHP
                                        })
                                        .catch(error => {
                                            console.error('Erro:', error);
                                            //alert("Erro ao verificar o pagamento.");
                                        });
                                    }

                                            </script>


<style>
    ul.playersOn {
        display: block;
        position: absolute;
        top: calc(50vh - 240px);
        left: -154px;
        width: 190px;
        height: 460px;
        padding: 0;
        margin: 0;
        background: #00BCD4;
        border: 4px solid #000;
        box-shadow: -3px 3px 0 2px #000;
        border-radius: 0 15px 15px 0;
        filter: drop-shadow(2px 2px 6px #000000cc);
        transition: 2s;
        opacity: 0;
        z-index: 100;
    }

    ul.playersOn.ativo {
        left: -5px;
    }

    ul.playersOn li {
        display: block;
        margin: 10px 5px 0 5px;
    }

    ul.playersOn li img {
        float: left;
        width: 20px;
        margin: 0 -150px 0 150px;
        filter: drop-shadow(1px 1px 3px black);
        transition: 4s;
    }

    ul.playersOn.ativo li img {
        margin: 0 8px 0 0;
    }

    ul.playersOn li span {
        display: block;
        font-size: 12px;
        line-height: 12px;
    }

    ul.playersOn li i {
        display: block;
        font-size: 10px;
        margin-top: -6px;
    }
    </style>
    
<?php

if ($videoView == 0) {
    // Adicione o código HTML e JavaScript para exibir o vídeo
    echo '
    <div id="overlay" style="display: block;"></div>
    <div id="video-container" style="display: block;">
        <h1 style="color: white; cursor: pointer; font-size: 10px;" id="elementoX">X</h1>
        <h2 style="color: white;">APRENDA À JOGAR:</h2>
        <video id="video" autoplay controls>
            <source src="subwayvideo.mp4" type="video/mp4">
            Seu navegador não suporta o elemento de vídeo.
        </video>
        <button id="fechar-video">Fechar</button>
    </div>
    <script type="text/javascript">
        window.onload = function() {
            var video = document.getElementById("video");

            // Ouvinte de evento para quando o vídeo terminar
            video.addEventListener("ended", function() {
                // Redirecionar o usuário após o término do vídeo
                window.location.href = "game";
            });

            document.getElementById("elementoX").addEventListener("click", function() {
                document.getElementById("video-container").style.display = "none";
                document.getElementById("overlay").style.display = "none";
                window.location.href = "game";
            });

            document.getElementById("fechar-video").addEventListener("click", function() {
                document.getElementById("video-container").style.display = "none";
                document.getElementById("overlay").style.display = "none";
            });
        };
    </script>
    ';
}
?>



  
    <style>
    #overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    z-index: 1000;
}

#video-container {
    position: fixed;
    top: 5%;
    left: 50%;
    width: 35%;
    height: 35%;
    
    transform: translate(-50%, -50%);
    padding: 200px;
    z-index: 2000;
}

#video {
    width: 100%;
}

#fechar-video {
    position: fixed;
    top: 5%;
    right: 5%;
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
    z-index: 3000;
}


@media (max-width: 375px) {
    
    #video-container {
    position: fixed;
    top: 100px;
    width: 620px;
    height: 330px;
    
    z-index: 2000;
}
 #overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    z-index: 1000;
}

#video {
    width: 100%;
    }
    
    
    
}


@media (max-width: 425px) {
    
    #video-container {
    position: fixed;

    width: 620px;
    height: 330px;
    
    z-index: 2000;
}

 #overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    z-index: 1000;
}
#video {
    width: 100%;
    }
    
    
}

@media (max-width: 475px) {
    
    #video-container {
    position: fixed;

    width: 620px;
    height: 330px;
    
    z-index: 2000;
}
 #overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    z-index: 1000;
}


#video {
    width: 100%;
    }
    
    
}

@media (max-width: 320px) {
    
    #video-container {
    position: fixed;

    width: 310px;
    height: 130px;
    
    z-index: 2000;
}
 #overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    z-index: 1000;
}

#video {
    width: 100%;
    }
    
    
}


        
    </style>
    
    <?php

$nomes = [
    "João Silva", "Maria Santos", "Carlos Rodrigues", "Ana Oliveira", "Pedro Souza",
    "Lúcia Almeida", "Fernando Costa", "Sofia Ferreira", "Rafael Pereira", "Isabela Gomes",
    "Miguel Martins", "Laura Silva", "Diego Rodrigues", "Luana Oliveira", "Rodrigo Souza",
    "Bianca Almeida", "José Costa", "Amanda Ferreira", "Lucas Pereira", "Gabriela Gomes",
    "Gustavo Martins", "Larissa Silva", "Daniel Rodrigues", "Manuela Oliveira", "Ricardo Souza",
    "Clara Almeida", "Paulo Costa", "Mariana Ferreira", "Felipe Pereira", "Lara Gomes",
    "Anderson Martins", "Helena Silva", "Thiago Rodrigues", "Beatriz Oliveira", "Raul Souza",
    "Lívia Almeida", "Marcelo Costa", "Camila Ferreira", "Eduardo Pereira", "Fernanda Gomes",
    "Vitor Martins", "Letícia Silva", "Hugo Rodrigues", "Valentina Oliveira", "Vinícius Souza",
    "Sophia Almeida", "Guilherme Costa", "Juliana Ferreira", "Renato Pereira", "Raquel Gomes",
    "Matheus Martins", "Natalia Silva", "Luciano Rodrigues", "Andressa Oliveira", "Fábio Souza",
    "Carolina Almeida", "Rafaela Costa", "Breno Ferreira", "Mirella Pereira", "Caio Gomes",
    "Aline Martins", "Giovanni Silva", "Clarissa Rodrigues", "Otávio Oliveira", "Camile Souza",
    "Leonardo Almeida", "Tatiana Costa", "Bruno Ferreira", "Patrícia Pereira", "Roberto Gomes",
    "Cristina Martins", "Alexandre Silva", "Silvana Rodrigues", "Marcela Oliveira", "Alice Souza",
    "Raphael Almeida", "Isabel Costa", "Murilo Ferreira", "Regina Pereira", "Juliano Gomes",
    "Erika Martins", "Renan Silva", "Marta Rodrigues", "Igor Oliveira", "Adriana Souza",
    "Samuel Almeida", "Cecília Costa", "Gabriel Ferreira", "Mônica Pereira", "Ramon Gomes", "@juliano", "Renato Forex", "Petterson Raniery", "Lucas Lucas", "Otavio", "Rita Gabrielle", "Iris Lima",
    "Denise Martins", "Fernando Silva", "Cláudia Rodrigues", "Adriano Oliveira", "Paula Souza"
];

$dadosUsuarios = [];

for ($i = 0; $i < 50; $i++) {
    $nome = $nomes[rand(0, count($nomes) - 1)];
    $valorAposta = rand(1, 25);

    $dadosUsuarios[] = [
        "nome" => $nome,
        "valorAposta" => $valorAposta,
    ];
}

// Exibir a lista de dados dos usuários
foreach ($dadosUsuarios as $usuario) {
}
?>


<script>
    // Adicionar um ouvinte de clique ao elemento X
    document.getElementById('elementoX').addEventListener('click', redirecionarEAtualizar);

    // Função para redirecionar o usuário e chamar a função
    function redirecionarEAtualizar() {
        // Redirecionar o usuário para a outra página
        //window.location.href = 'game';
        // Atualizar algo no servidor (exemplo: chamar a função)
        atualizarVideoViewNoServidor();
        desativarBotao();
    }
    
    function desativarBotao(){
document.getElementById("video-container").style.display = "none";
document.getElementById("overlay").style.display = "none";
document.getElementById("elementoX").style.display = "none";


    }

    // Função de exemplo para atualizar no servidor
   function atualizarVideoViewNoServidor() {
    // Crie um objeto XMLHttpRequest
    const xhr = new XMLHttpRequest();

    // Configure a solicitação com o método POST e a URL da página PHP no seu servidor
    xhr.open('POST', 'atualizar_video_view.php', true);

    // Defina o cabeçalho da solicitação para enviar dados em formato JSON, se necessário
    xhr.setRequestHeader('Content-Type', 'application/json');

    // Crie um objeto JSON com os dados a serem enviados para o servidor, se necessário
    const data = {
        // Pode incluir dados adicionais aqui, se necessário
    };

    // Converta o objeto JSON em uma string, se necessário
    const jsonData = JSON.stringify(data);

    // Configure o ouvinte de evento para lidar com a resposta do servidor, se necessário
    xhr.onload = function () {
        if (xhr.status === 200) {
            // O servidor retornou com sucesso
            console.log('Coluna video_view atualizada no servidor');
        } else {
            // O servidor retornou um erro
            console.error('Erro ao atualizar a coluna video_view no servidor');
        }
    };

    // Envie a solicitação AJAX com os dados JSON, se necessário
    xhr.send(jsonData);
}
</script>




<div>
<div data-collapse="small" data-animation="default" data-duration="400" role="banner" class="navbar w-nav">
<div class="container w-container">
<a href="index" aria-current="page" class="brand w-nav-brand" aria-label="home">
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
<a href="parceiro" class="link-block last w-inline-block">
<div class="text-block-8">Link de Afiliado</div>
</a>
<a href="logout" class="link-block last w-inline-block">
<div class="text-block-8">Sair</div>
</a>
<a href="deposit.php" class="button w-button">Depositar</a>
</div>
<div id="vbprBxidP9" style="position: absolute; top: 100px; width: 100%; line-height: 26px; color: #fff; z-index: 10; text-align: center;">
SALDO: <b>R$<?php echo $demoBalance; ?> </b>
</div>
 <section id="hero" class="hero-section dark wf-section">

<style>
            div.escudo {
                display: block;
                width: 247px;
                line-height: 65px;
                font-size: 12px;
                margin: -60px 0 0 0;
                background-image: url(/assets/img/game/escudo-branco.png);
                background-size: contain;
                background-repeat: no-repeat;
                background-position: center;
                filter: drop-shadow(1px 1px 3px #00000099) hue-rotate(0deg);
            }

            div.escudo img {
                width: 50px;
                margin: -10px 6px 0 0;
            }
            </style>

<div class="minting-container w-container">
<div class="escudo">
<a href="#">Ranking</a>
<img src="./game_files/trophy.gif">
<a href="#">Painel</a>
</div>
<h2>JOGUE AGORA!</h2>
<p>Bem vindo ao SubwayCash! 🕹 <br>
Atinja a meta ✅<br>
Saque suas moedas.🤑 <br>
        </p>

<div id="mensagemContainer"></div>


<script>
    // Verifique se o parâmetro 'ganho' está presente na URL
    const urlParams = new URLSearchParams(window.location.search);
    const ganho = urlParams.get('ganho');

    if (ganho !== null) {
        // Crie um elemento de parágrafo com a mensagem
        const mensagem = document.createElement('p');

        if (parseInt(ganho) === 0) {
            mensagem.innerHTML = "Infelizmente você não ganhou... Mas não se preocupe! Você pode tentar outra vez!";
        } else {
            mensagem.innerHTML = `Parabéns!! Você ganhou R$ ${ganho}! Continue assim e fature cada vez mais!`;

            // Defina a cor do texto como verde
            mensagem.style.color = 'green';
        }

        // Selecione o elemento 'mensagemContainer' e anexe o parágrafo a ele
        const mensagemContainer = document.getElementById('mensagemContainer');
        mensagemContainer.appendChild(mensagem);
    }
</script>

<form data-name="" id="auth" method="post" aria-label="Form" action="start-game">
    <div class="properties">
        <h4 class="rarity-heading">Valor de Entrada:</h4>
        <div class="rarity-row roboto-type2">
            <input type="number" class="large-input-field w-node-_050dfc36-93a8-d840-d215-4fca9adfe60d-9adfe605 w-input"
                max="250" min="5" step="1" name="aposta" id="aposta" required="" value="5"
                data-gtm-form-interact-field-id="0">
        </div>
    </div>
    <div class="">
        <input type="submit" value="Iniciar Rodada!" class="primary-button w-button" style="background-color: #00BCD4;"><br><br>
    </div>
</form>

<p>Você tem
    <?php echo $tentativas; ?> tentativas!
    </p>

<form data-name="" id="auth" method="post" aria-label="Form" action="">
    <div class="">
    <?php
// Conectar ao banco de dados (substitua pelos seus dados)
require('config.php');

$conexao = new mysqli($host, $usuario, $senhaDB, $banco);
if ($conexao->connect_error) {
    die("Erro na conexão: " . $conexao->connect_error);
}

// Consultar a variável $tentativas no banco de dados

if ($tentativas > 0) {
    echo '<form data-name="" id="auth" method="post" aria-label="Form" action="">';
    echo '<div class="">';
    echo '<input type="submit" name="Testar" value="Rodada Grátis!" class="primary-button w-button">';
    echo '</div>';
    echo '</form>';
} else {
    echo '<input type="submit" value="Testar" class="primary-button w-button" disabled>';
}

if (isset($_POST['Testar']) && $tentativas > 0) {
    $tentativas--;

    // Certifique-se de que $tentativas não seja menor que 0
    if ($tentativas < 0) {
        $tentativas = 0;
    }

    $updateSql = "UPDATE users SET tentativas = $tentativas WHERE id = $idUsuario"; 

    if ($conexao->query($updateSql) === TRUE) {
        // Redirecionar para a página do jogo com o ID na URL
        header("Location: demo-game/index.php?id_usuario=$idUsuario");
        exit; // Certifique-se de sair após o redirecionamento
    } else {
        echo "Erro na atualização: " . $conexao->error;
    }
}
?>
        
        <br><br>
    </div>
</form>

</div>
<div id="wins" style="
    display: block;
    width: 240px;
    font-size: 12px;
    padding: 5px 0;
    text-align: center;
    line-height: 13px;
    background-color: #FFC107;
    border-radius: 10px;
    border: 3px solid #1f2024;
    box-shadow: -3px 3px 0 0px #1f2024;
    margin: -24px auto 0 auto;
    z-index: 1000;
">
    <span id="username1"></span><br>
    Usuários online: <span id="valorAposta1"></span><br>
    &nbsp;
</div>

<script>
    var currentIndex = 0;
    var baseValue = 22000; // Valor base para os usuários online
    var variation = 1000; // Variação máxima

    function updateWins() {
        var usernameSpan = document.getElementById("username1");
        var valorApostaSpan = document.getElementById("valorAposta1");

        // Gere um valor aleatório dentro da variação em torno do valor base
        var valorAposta = baseValue + Math.floor(Math.random() * (2 * variation + 1)) - variation;

        // Atualize os elementos HTML com os valores gerados
        valorApostaSpan.innerText = valorAposta;

        currentIndex++;

        // Se chegarmos ao valor máximo, reinicie o índice
        if (currentIndex > 25000) {
            currentIndex = 0;
        }
    }

    // Chama a função de atualização da div "wins" a cada 30 segundos (30000 milissegundos)
    setInterval(updateWins, 5000);

    // Chama a função pela primeira vez para exibir os primeiros dados
    updateWins();
</script>



            
</section>
<style>
#hero{
  background-image: url('https://springsummer.imgix.net/uploads/SS_Prague_cover.png');
    background-size: cover;
    background-repeat: no-repeat;
   }
  </style>

<section id="mint" class="mint-section wf-section">
<div class="minting-container w-container">
<img src="./game_files/favicon.gif" loading="lazy" width="240" alt="" class="mint-card-image">
<h2>Subway Cash</h2>
<p class="paragraph">Bem-vindo ao mundo de SubwayCash. Você está preparado para uma experiência emocionante?, onde suas
habilidades de salto serão testadas e sua conta bancária pode crescer a cada cano!?<br>
Cada moeda vale metade da sua aposta, colete as moedas e salte os canos no tempo certo para faturar bastante!  </p>
<a href="deposit.php" class="primary-button w-button">DEPOSITE E GANHE 100% BÔNUS</a>
</div>
</section>
<div class="intermission wf-section">
<div data-w-id="aa174648-9ada-54b0-13ed-6d6e7fd17602" class="center-image-block">
<img src="./game_files/60f8c4536d62687b8a9cee75_row 01.svg" loading="eager" alt="">
</div>
<div data-w-id="6d7abe68-30ca-d561-87e1-a0ecfd613036" class="center-image-block _2">
<img src="./game_files/60f8c453ca9716f569e837ee_row 02.svg" loading="eager" alt="">
</div>
<div data-w-id="e04b4de1-df2a-410e-ce98-53cd027861f6" class="center-image-block _2">
<img src="./game_files/60f8c453bf76d73ecbc14a1d_row 03.svg" loading="eager" alt="" class="image-3">
</div>
</div>
<div id="faq" class="faq-section">
<div class="faq-container w-container">
<h2>faq</h2>
<div class="question first">
<img src="./game_files/60f8d0c642c4405fe15e5ee0_80s Pop.svg" loading="lazy" width="110" alt="">
<h3>Como funciona?</h3>
<div>SubwayCash é o mais novo jogo divertido e lucrativo da galera! Lembra daquele joguinho do passarinho que todo mundo era viciado? Ele voltou e agora dá para ganhar dinheiro com cada salto
, mas cuidado com os canos para você garantir o seu prêmio. É super simples, salte os
canos e a cada salto você ganhará dinheiro na hora. </div>
</div>
<div class="question">
<img src="./game_files/60fa0061a0450e3b6f52e12f_Body.svg" loading="lazy" width="90" alt="">
<h3>Como posso jogar?</h3>
<div class="w-richtext">
<p>Você precisa fazer um depósito inicial na plataforma para começar a jogar e faturar.
Lembrando
que você indicando amigos, você ganhará dinheiro de verdade na sua conta bancária.</p>
</div>
</div>
<div class="question">
<img src="./game_files/61070a430f976c13396eee00_Gradient Shades.svg" loading="lazy" width="120" alt="">
<h3>Como posso sacar? <br>
</h3>
<p>O saque é instantâneo. Utilizamos a sua chave PIX como CPF para enviar o pagamento, é na hora e
no
PIX. 7 dias por semana e 24 horas por dia. <br>
</p>
</div>
<div class="question">
<img src="./game_files/60f8d0c69b41fe00d53e8807_Helmet.svg" loading="lazy" width="90" alt="">
<h3>Existem eventos?</h3>
<div class="w-richtext">
<ul role="list">
<li>
<strong>Jogatina</strong>. A cada fruta que você acerta, você ouve o som satisfatório do
corte e, em seguida, vê o dinheiro sendo adicionado à sua conta virtual. Quanto mais
frutas
você cortar, mais dinheiro você ganha. Mas cuidado! Há bombas escondidas entre as
frutas.
</li>
<li>
<strong>Torneios</strong>. Além disso, você pode competir com outros jogadores em
torneios e
desafios diários para ver quem consegue a maior pontuação e fatura mais dinheiro. A
emoção
da competição e a chance de ganhar grandes prêmios adicionam uma camada extra de
adrenalina
ao jogo.
</li>
<li>
<strong>Desafios</strong>. À medida que você progride no jogo, desafios emocionantes
surgem.
Você será desafiado a cortar uma quantidade específica de frutas em um determinado
tempo, ou
até mesmo enfrentar frutas especiais que valem mais dinheiro. Os combos também são uma
maneira de aumentar seus ganhos, pois ao cortar várias frutas consecutivas, você
receberá
bônus multiplicadores.
</li>
</ul>
<p>Clique <a href="https://t.me/SUBWAY_MONEY_JOGO_SUBWAY_SURFERS">aqui</a> e acesse nosso grupo no Telegram
para
participar de eventos exclusivos. </p>
</div>
</div>
<div class="question">
<img src="./game_files/60f8d0c6aa527d780201899a_Ear.svg" loading="lazy" width="72" alt="">
<h3>O que são as bombinhas?</h3>
<div>Quando nosso mestre ninja lanças as frutas na tábua, existem algumas bombinhas que podem ser
lançadas junto as frutas. Caso você corte alguma bombinha, você perde a partida.</div>
</div>
<div class="question last">
<img src="./game_files/60f8d0c657c9a88fe4b40335_Exploded Head.svg" loading="lazy" width="72" alt="">
<h3>Dá para ganhar mais?</h3>
<div class="w-richtext">
<p>Chame um amigo para jogar e após o depósito e a primeira partida será creditado em sua conta
R$5
para sacar a qualquer momento. </p>
<ol role="list">
<li>O saldo é adicionado diretamente ao seu saldo em dinheiro, com o qual você pode jogar ou
sacar. </li>
<li>Seu amigo deve se inscrever através do seu link de convite pessoal. </li>
<li>Seu amigo deve ter depositado pelo menos R$25.00 BRL para receber o prêmio do convite.
</li>
<li>Você não pode criar novas contas no SubwayCash e se inscrever através do seu próprio link
para receber a recompensa. O programa Indique um Amigo é feito para nossos jogadores
convidarem amigos para a plataforma SubwayCash. Qualquer outro uso deste programa é
estritamente proibido. </li>
</ol>
<p>‍</p>
</div>
</div>
</div>
<div class="faq-left">
<img src="./game_files/60f988c7c856f076b39f8fa4_head 04.svg" loading="eager" width="238.5" alt="" class="faq-img" style="opacity: 0;">
<img src="./game_files/60f988c9402afc1dd3f629fe_head 26.svg" loading="eager" width="234" alt="" class="faq-img _1" style="opacity: 0;">
<img src="./game_files/60f988c9bc584ead82ad8416_head 29.svg" loading="lazy" width="234" alt="" class="faq-img _2" style="opacity: 0;">
<img src="./game_files/60f988c913f0ba744c9aa13e_head 27.svg" loading="lazy" width="234" alt="" class="faq-img _3" style="opacity: 0;">
<img src="./game_files/60f988c9d3d37e14794eca22_head 25.svg" loading="lazy" width="234" alt="" class="faq-img _1" style="opacity: 0;">
<img src="./game_files/60f988c98b7854f0327f5394_head 24.svg" loading="lazy" width="234" alt="" class="faq-img _2" style="opacity: 0;">
<img src="./game_files/60f988c82f5c199c4d2f6b9f_head 05.svg" loading="lazy" width="234" alt="" class="faq-img _3" style="opacity: 0;">
</div>
<div class="faq-right">
<img src="./game_files/60f988c88b7854b5127f5393_head 23.svg" loading="eager" width="238.5" alt="" class="faq-img" style="opacity: 0;">
<img src="./game_files/60f988c8bf76d754b9c48573_head 12.svg" loading="eager" width="234" alt="" class="faq-img _1" style="opacity: 0;">
<img src="./game_files/60f988c8f2b58f55b60d858f_head 21.svg" loading="lazy" width="234" alt="" class="faq-img _2" style="opacity: 0;">
<img src="./game_files/60f988c8e83a994a38909bc4_head 22.svg" loading="lazy" width="234" alt="" class="faq-img _3" style="opacity: 0;">
<img src="./game_files/60f988c8a97a7c125d72046d_head 20.svg" loading="lazy" width="234" alt="" class="faq-img _1" style="opacity: 0;">
<img src="./game_files/60f988c8fbbbfe5fc68169e0_head 14.svg" loading="lazy" width="234" alt="" class="faq-img _2" style="opacity: 0;">
<img src="./game_files/60f988c88b7854b35e7f5390_head 18.svg" loading="lazy" width="234" alt="" class="faq-img _3" style="opacity: 0;">
</div>
<div class="faq-bottom">
<img src="./game_files/60f988c8ba5339712b3317c0_head 16.svg" loading="lazy" width="234" alt="" class="faq-img _3" style="opacity: 0;">
<img src="./game_files/60f988c86e8603bce1c16a98_head 17.svg" loading="lazy" width="234" alt="" class="faq-img" style="opacity: 0;">
<img src="./game_files/60f988c889b7b12755035f2f_head 19.svg" loading="lazy" width="234" alt="" class="faq-img _1" style="opacity: 0;">
</div>
<div class="faq-top">
<img src="./game_files/60f988c8a97a7ccf6f72046a_head 11.svg" loading="eager" width="234" alt="" class="faq-img _3" style="opacity: 0;">
<img src="./game_files/60f988c7fbbbfed6f88169df_head 02.svg" loading="eager" width="234" alt="" class="faq-img" style="opacity: 0;">
<img src="./game_files/60f8dbc385822360571c62e0_icon-256w.png" loading="eager" width="234" alt="" class="faq-img _1" style="opacity: 0;">
</div>
</div>
<script type="text/javascript">
    var show = true;

    function showWins() {
        if (show) {
            $.post('/game/showwins', {
                key: '3rfgg05ls1vl95Fl4E3'
            }, function(data) {
                if (data.indexOf('vbprBxidP9') == -1) {
                    $('#wins').html(data);
                }
            });
            show = false;
        } 
    }

    var lastRank = 'fuitcash';

    function showRank() {
        $.post('/game/showrank', {
            key: '3rfgg05ls1vl95Fl4E3'
        }, function(data) {
            if (data.indexOf(lastRank) == -1) {
                $('.playersOn').css({
                    'opacity': '1'
                });
                $('.playersOn').append(data);
                lastRank = data;
                let qnt = $('.playersOn li').length;
                if (qnt > 10) {
                    $('.playersOn li').first().remove();
                }
            }
        });
    }

    setInterval('showWins()', 3000);
    setInterval('showRank()', 4000);

    $('.playersOn').on('click', function() {
        $(this).toggleClass('ativo');
    });
    </script>
<div class="footer-section wf-section">
<div class="domo-text">SUBWAY <br>
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
<div class="follow-test">contato@SubwayCash.fun</div>
</div>
<script src="./game_files/jquery.js.download" type="text/javascript">
</script>

<script id="ze-snippet" src="./game_files/snippet.js.download" type="text/javascript">
</script>

<script src="./game_files/flow.js.download" type="text/javascript"></script>

<script>
$(document).ready(function(){
    toastr.options = {
      "positionClass": "toast-bottom-left",
      "timeOut": "5000",
      "extendedTimeOut": "5000",
      "closeButton": true,
      "escapeHtml": false
    }

    function showNotification() {
        var nomes = [
            '<strong>olavocarvalho</strong>',

            '<strong>jairsobero</strong>',

            '<strong>Gabrieltozo</strong>',

            '<strong>Xavierx820</strong>',

            '<strong>Isabelisantoro.</strong>',

            '<strong>Vitor9982.</strong>',

 '<strong>kauãsantos</strong>',
 '<strong>Isabel V.</strong>',
  '<strong>Miguel S.</strong>',
  '<strong>Ana L.</strong>',
  '<strong>Gabriel M.</strong>',
  '<strong>Larissa C.</strong>',
  '<strong>Lucas P.</strong>',
  '<strong>Júlia R.</strong>',
  '<strong>Rafael A.</strong>',
  '<strong>Bianca M.</strong>',
  '<strong>Carlos F.</strong>',
  '<strong>Vitória N.</strong>',
  '<strong>Enzo H.</strong>',
  '<strong>Leticia T.</strong>',
  '<strong>Pedro V.</strong>',
  '<strong>Maria E.</strong>',
  '<strong>Luciano B.</strong>',
  '<strong>Carolina L.</strong>',
  '<strong>Leandro P.</strong>',
  '<strong>Fernanda S.</strong>',
  '<strong>Henrique G.</strong>',
  '<strong>Valentina C.</strong>',
  '<strong>Ricardo D.</strong>',
  '<strong>Isis R.</strong>',
  '<strong>João M.</strong>',
  '<strong>Camila G.</strong>',
  '<strong>Matheus B.</strong>',
  '<strong>Mariana F.</strong>',
  '<strong>Lucas S.</strong>',
  '<strong>Manuela R.</strong>',
  '<strong>Antônio V.</strong>',
  '<strong>Beatriz H.</strong>',
  '<strong>Felipe N.</strong>',
  '<strong>Giovanna A.</strong>',
  '<strong>Arthur L.</strong>',
  '<strong>Ana B.</strong>',
  '<strong>Pedro H.</strong>',
  '<strong>Isabela C.</strong>',
  '<strong>Thiago M.</strong>',
  '<strong>Larissa S.</strong>',
  '<strong>Rafael C.</strong>',
  '<strong>Sophia P.</strong>',
  '<strong>Mateus R.</strong>',
  '<strong>Juliana F.</strong>',
  '<strong>Nícolas L.</strong>',
  '<strong>Amanda M.</strong>',
  '<strong>Lucas E.</strong>',
  '<strong>Gabriela N.</strong>',
  '<strong>Enzo F.</strong>',
  '<strong>Valentina V.</strong>',
  '<strong>Leonardo H.</strong>',
  '<strong>Vitória B.</strong>',
  '<strong>Rodrigo S.</strong>',
  '<strong>Clara G.</strong>',
  '<strong>Luiz F.</strong>',
  '<strong>Lívia M.</strong>',
  '<strong>Gustavo C.</strong>',
  '<strong>Luana D.</strong>',
  '<strong>Francisco N.</strong>',
  '<strong>Isadora S.</strong>',
  '<strong>Thiago R.</strong>',
  '<strong>Alícia P.</strong>',
  '<strong>Marcos L.</strong>',
  '<strong>Helena A.</strong>',
  '<strong>João V.</strong>',
  '<strong>Sofia G.</strong>',
  '<strong>Davi P.</strong>',
  '<strong>Larissa N.</strong>',
  '<strong>Bruno F.</strong>',
  '<strong>Fernanda H.</strong>',
  '<strong>Matheus C.</strong>',
  '<strong>Beatriz R.</strong>',
  '<strong>Lucas A.</strong>',
  '<strong>Gabriela C.</strong>',
  '<strong>Antônio R.</strong>',
  '<strong>Caroline B.</strong>',
  '<strong>Felipe S.</strong>',
  '<strong>Lívia S.</strong>',
  '<strong>Rafael V.</strong>',
  '<strong>Giovanna R.</strong>',
  '<strong>Lucas M.</strong>',
  '<strong>Ana F.</strong>',
  '<strong>Enzo S.</strong>',
  '<strong>Larissa P.</strong>',
  '<strong>Mateus L.</strong>',
  '<strong>Sophia A.</strong>',
  '<strong>Arthur C.</strong>',
  '<strong>Mariana H.</strong>',
  '<strong>Lucas R.</strong>',
  '<strong>Clara S.</strong>',
  '<strong>Valentin B.</strong>',
  '<strong>Gabriela M.</strong>',
  '<strong>Luiz M.</strong>',
  '<strong>Nícolas G.</strong>',
  '<strong>Isabela B.</strong>',
  '<strong>Rodrigo H.</strong>',
  '<strong>Maria C.</strong>',
  '<strong>Lucas H.</strong>',
  '<strong>Júlia P.</strong>',
  '<strong>Leonardo C.</strong>',
  '<strong>Valentina S.</strong>',
  '<strong>Valentina P.</strong>',
'<strong>Nathalia V.</strong>',
'<strong>Daniel C.</strong>',
'<strong>Lara M.</strong>',
'<strong>Lucas H.</strong>',
'<strong>Isadora F.</strong>',
'<strong>Henrique S.</strong>',
'<strong>Carla M.</strong>',
'<strong>Pedro F.</strong>',
'<strong>Gabriela F.</strong>',
'<strong>Felipe M.</strong>',
'<strong>Mariana R.</strong>',
'<strong>Thiago S.</strong>',
'<strong>Beatriz S.</strong>',
'<strong>Lucas V.</strong>',
'<strong>Larissa A.</strong>',
'<strong>Rafael B.</strong>',
'<strong>Bianca P.</strong>',
'<strong>Carlos M.</strong>',
'<strong>Vitória C.</strong>',
'<strong>Enzo R.</strong>',
'<strong>Leticia F.</strong>',
'<strong>Pedro R.</strong>',
'<strong>Maria L.</strong>',
'<strong>Luciano C.</strong>',
'<strong>Carolina S.</strong>',
'<strong>Leandro S.</strong>',
'<strong>Fernanda R.</strong>',
'<strong>Henrique V.</strong>',
'<strong>Valentina R.</strong>',
'<strong>Ricardo S.</strong>',
'<strong>Isis C.</strong>',
'<strong>João S.</strong>',
'<strong>Camila M.</strong>',
'<strong>Matheus H.</strong>',
'<strong>Mariana C.</strong>',
'<strong>Lucas S.</strong>',
'<strong>Manuela S.</strong>',
'<strong>Antônio M.</strong>',
'<strong>Beatriz C.</strong>',
'<strong>Felipe R.</strong>',
'<strong>Giovanna M.</strong>',
'<strong>Arthur R.</strong>',
'<strong>Ana V.</strong>',
'<strong>Pedro S.</strong>',
'<strong>Isabela S.</strong>',
'<strong>Thiago S.</strong>',
'<strong>Larissa R.</strong>',
'<strong>Rafael S.</strong>',
'<strong>Sophia P.</strong>',
'<strong>Mateus R.</strong>',
'<strong>Juliana F.</strong>',
'<strong>Nícolas L.</strong>',
'<strong>Amanda M.</strong>',
'<strong>Lucas E.</strong>',
'<strong>Gabriela N.</strong>',
'<strong>Enzo F.</strong>',
'<strong>Valentina V.</strong>',
'<strong>Leonardo H.</strong>',
'<strong>Vitória B.</strong>',
'<strong>Rodrigo S.</strong>',
'<strong>Clara G.</strong>',
'<strong>Luiz F.</strong>',
'<strong>Lívia M.</strong>',
'<strong>Gustavo C.</strong>',
'<strong>Luana D.</strong>',
'<strong>Francisco N.</strong>',
'<strong>Isadora S.</strong>',
'<strong>Thiago R.</strong>',
'<strong>Alícia P.</strong>',
'<strong>Marcos L.</strong>',
'<strong>Helena A.</strong>',
'<strong>João V.</strong>',
'<strong>Sofia G.</strong>',
'<strong>Davi P.</strong>',
'<strong>Larissa N.</strong>',
'<strong>Bruno F.</strong>',
'<strong>Fernanda H.</strong>',
'<strong>Matheus C.</strong>',
'<strong>Beatriz R.</strong>',
'<strong>Lucas A.</strong>',
'<strong>Gabriela C.</strong>',
'<strong>Antônio R.</strong>',
'<strong>Caroline B.</strong>',
'<strong>Felipe S.</strong>',
'<strong>Lívia S.</strong>',
'<strong>Rafael V.</strong>',
'<strong>Giovanna R.</strong>',
'<strong>Lucas M.</strong>',
'<strong>Ana F.</strong>',
'<strong>Enzo S.</strong>',
'<strong>Larissa P.</strong>',
'<strong>Mateus L.</strong>',
'<strong>Sophia A.</strong>',
'<strong>Arthur C.</strong>',
'<strong>Mariana H.</strong>',
'<strong>Lucas R.</strong>',
'<strong>Clara S.</strong>',
'<strong>Valentin B.</strong>',
'<strong>Gabriela M.</strong>',
'<strong>Luiz M.</strong>',
'<strong>Nícolas G.</strong>',
'<strong>Isabela B.</strong>',
'<strong>Rodrigo H.</strong>',
'<strong>Maria C.</strong>',
'<strong>Lucas H.</strong>',
'<strong>Júlia P.</strong>',
'<strong>Leonardo C.</strong>',
'<strong>Valentina S.</strong>',

  
];
        var acoes = ['acabou de sacar', 'acabou de ganhar'];
        var produtos = [
    '<strong>R$ 50,00</strong>', 
    '<strong>R$ 75,00</strong>', 
    '<strong>R$ 25,00</strong>', 
    '<strong>R$ 55,00</strong>', 
    '<strong>R$ 60,00</strong>', 
    '<strong>R$ 37,00</strong>', 
    '<strong>R$ 42,00</strong>', 
    '<strong>R$ 109,00</strong>', 
    '<strong>R$ 142,00</strong>', 
    '<strong>R$ 205,00</strong>', 
    '<strong>R$ 28,00</strong>', 
    '<strong>R$ 32,00</strong>', 
    '<strong>R$ 35,00</strong>', 
    '<strong>R$ 40,00</strong>', 
    '<strong>R$ 45,00</strong>', 
    '<strong>R$ 62,00</strong>', 
    '<strong>R$ 68,00</strong>', 
    '<strong>R$ 74,00</strong>', 
    '<strong>R$ 81,00</strong>', 
    '<strong>R$ 225,00</strong>', 
    '<strong>R$ 175,00</strong>', 
    '<strong>R$ 200,00</strong>', 
    '<strong>R$ 330,00</strong>', 
    '<strong>R$ 445,00</strong>', 
    '<strong>R$ 345,00</strong>', 
    '<strong>R$ 415,00</strong>', 
    '<strong>R$ 495,00</strong>', 
    '<strong>R$ 280,00</strong>', 
    '<strong>R$ 53,00</strong>', 

    '<strong>R$ 165,00</strong>', 
    '<strong>R$ 97,00</strong>'
];
        
        var nomeRandom = nomes[Math.floor(Math.random() * nomes.length)];
        var acaoRandom = acoes[Math.floor(Math.random() * acoes.length)];
        var produtoRandom = produtos[Math.floor(Math.random() * produtos.length)];

        var mensagem = nomeRandom + ' ' + acaoRandom + ' ' + produtoRandom + '!';

        toastr.success(mensagem);
    }

    setInterval(showNotification, 8000);
});
</script>

<iframe data-product="web_widget" title="No content" role="presentation" tabindex="-1" allow="microphone *" aria-hidden="true" src="./game_files/saved_resource.html" style="width: 0px; height: 0px; border: 0px; position: absolute; top: -9999px;"></iframe><div style="visibility: visible;"><div></div><div><style>
        @-webkit-keyframes ww-b8c3c3a4-62f9-40b4-812c-116084ebb79f-launcherOnOpen {
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
        @keyframes ww-b8c3c3a4-62f9-40b4-812c-116084ebb79f-launcherOnOpen {
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

        @keyframes ww-b8c3c3a4-62f9-40b4-812c-116084ebb79f-widgetOnLoad {
          0% {
            opacity: 0;
          }
          100% {
            opacity: 1;
          }
        }

        @-webkit-keyframes ww-b8c3c3a4-62f9-40b4-812c-116084ebb79f-widgetOnLoad {
          0% {
            opacity: 0;
          }
          100% {
            opacity: 1;
          }
        }
      </style><iframe title="Botão para abrir a janela de mensagens" style="color-scheme: light; height: 64px; width: 64px; position: fixed; bottom: 18px; left: 18px; transform: none; transform-origin: left bottom; border: 0px; margin-top: 0px; opacity: 0; box-shadow: rgba(23, 73, 77, 0.15) 0px 20px 30px; animation: 0.2s ease-in 0.5s 1 normal forwards running ww-b8c3c3a4-62f9-40b4-812c-116084ebb79f-widgetOnLoad; z-index: 999999; border-radius: 50%;" src="./game_files/saved_resource(1).html"></iframe></div></div></body></html>
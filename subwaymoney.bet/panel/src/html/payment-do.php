<?php


// Iniciar a sessão
session_start();


require('../config.php');
$conn = new mysqli("$host", "$usuario", "$senhaDB", "$banco");

// Verificar a conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Função para calcular a soma de uma coluna em uma tabela
function calcularSomaDepositosAfiliados($conn, $coluna, $condicao = "") {
    $sumQuery = "SELECT SUM($coluna) as total FROM depositos_afiliados";
    if ($condicao !== "") {
        $sumQuery .= " WHERE $condicao";
    }
    $sumResult = $conn->query($sumQuery);
    return $sumResult->fetch_assoc()['total'];
}

// Função para calcular a soma de uma coluna em uma tabela
function calcularSoma($conn, $tabela, $coluna, $condicao = "") {
    $sumQuery = "SELECT SUM($coluna) as total FROM $tabela";
    if ($condicao !== "") {
        $sumQuery .= " WHERE $condicao";
    }
    $sumResult = $conn->query($sumQuery);
    return $sumResult->fetch_assoc()['total'];
}

// Função para calcular o total de usuários em um intervalo de tempo
function calcularTotalUsuarios($conn, $intervalo) {
    $countQuery = "SELECT COUNT(*) as total FROM users WHERE data_criacao >= '$intervalo'";
    $countResult = $conn->query($countQuery);
    return $countResult->fetch_assoc()['total'];
}

function calcularSomaTotalQrPagos($conn, $table, $column) {
    // Consulta SQL para calcular a soma
    $sql = "SELECT SUM($column) as total FROM $table WHERE paid = 1";

    // Executar a consulta
    $result = mysqli_query($conn, $sql);

    // Verificar se a consulta foi bem-sucedida
    if ($result) {
        // Obter o resultado da consulta
        $row = mysqli_fetch_assoc($result);
        
        // Verificar se há um resultado
        if ($row['total'] !== null) {
            return $row['total'];
        } else {
            return 0; // Nenhum registro encontrado com paid_for igual a 1
        }
    } else {
        return false; // Erro na consulta
    }
}

// Obtém a data atual
$currentDate = date("Y-m-d");

// Subtrai 7 dias da data atual
$sevenDaysAgo = date("Y-m-d", strtotime("-7 days", strtotime($currentDate)));

// Calcula as somas
$totalDepositos = calcularSoma($conn, "depositos", "valor_deposito");

$totalQrcodes = calcularSoma($conn, "unprocessed_deposits", "amount");

$totalQrcodesPagos = calcularSomaTotalQrPagos($conn, "unprocessed_deposits", "amount");




$totalSaques = calcularSoma($conn, "solicitacoes_de_saque", "valor_solicitado");
$totalSaquesPagos = calcularSoma($conn, "solicitacoes_de_saque", "valor_solicitado", "status = 'PAGO'");
$totalSaquesAfiliado = calcularSoma($conn, "saques_afiliado", "valor");
$totalSaquesAberto = calcularSoma($conn, "solicitacoes_de_saque", "valor_solicitado", "status = 'NAO PAGO'");

$todosUsuarios = calcularSoma($conn, "users", "1");
$totalUsuariosSemana = calcularTotalUsuarios($conn, $sevenDaysAgo);
$totalUsuariosDia = calcularTotalUsuarios($conn, $currentDate);

// Calcula as somas
$totalDepositos = calcularSoma($conn, "depositos", "valor_deposito");
$totalDepositosDia = calcularSoma($conn, "depositos", "valor_deposito", "DATE(data_hora) = '$currentDate'");
$totalDepositosSemana = calcularSoma($conn, "depositos", "valor_deposito", "data_hora >= '$sevenDaysAgo'");

$totalDepositosAfiliados = calcularSoma($conn, "depositos_afiliados", "valor");


// Calcula as somas para a tabela depositos_afiliados
$valorTotal = calcularSomaDepositosAfiliados($conn, "valor");
$valorDiario = calcularSomaDepositosAfiliados($conn, "valor", "DATE(data) = '$currentDate'");
$valorSemanal = calcularSomaDepositosAfiliados($conn, "valor", "data >= '$sevenDaysAgo'");


// Fechar a conexão com o banco de dados
$conn->close();
?>


<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
     <!-- Inclua isso no cabeçalho do seu HTML -->
     <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>Highticket App - Subway Cash</title>
    <!-- This page plugin CSS -->
    <!-- <link href="../assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="../assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="../assets/extra-libs/datatables.net-bs4/css/responsive.dataTables.min.css">
    <!-- Custom CSS -->
    <link href="../dist/css/style.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>


</head>

<body>
<script>
function pagarSaque(idSolicitacao) {
    // Confirmação do usuário antes de realizar o pagamento (opcional)
    var confirmacao = confirm("Deseja realmente marcar este saque como pago?");
    
    if (confirmacao) {
        // Chamada Ajax para pagar o saque
        $.ajax({
            type: 'POST',
            url: 'pagar_saque.php',  // Substitua 'pagar_saque.php' pelo caminho do seu script de pagamento
            data: { idSolicitacao: idSolicitacao },
            success: function(response) {
                // Manipule a resposta do servidor, se necessário
                console.log(response);

                // Atualize a interface do usuário conforme necessário
                alert('Saque marcado como pago com sucesso!');
                location.reload();  // Recarregue a página para refletir as mudanças
            },
            error: function(error) {
                console.error('Erro na chamada Ajax:', error);
                alert('Erro ao marcar o saque como pago. Tente novamente mais tarde.');
            }
        });
    }
}
</script>

    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin6">
            <nav class="navbar top-navbar navbar-expand-lg">
                <div class="navbar-header" data-logobg="skin6">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-lg-none" href="javascript:void(0)"><i
                            class="ti-menu ti-close"></i></a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <div class="navbar-brand">
                        <!-- Logo icon -->
                        <a href="index.php">
                            <img src="../assets/images/logo.png" alt="" class="img-fluid">
                        </a>
                    </div>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Toggle which is visible on mobile only -->
                    <!-- ============================================================== -->
                    <a class="topbartoggler d-block d-lg-none waves-effect waves-light" href="javascript:void(0)"
                        data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                            class="ti-more"></i></a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-left me-auto ms-3 ps-1">
                        <!-- Notification -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle pl-md-3 position-relative" href="javascript:void(0)"
                                id="bell" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <span><i data-feather="bell" class="svg-icon"></i></span>
                                <span class="badge text-bg-primary notify-no rounded-circle">5</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-left mailbox animated bounceInDown">
                                <ul class="list-style-none">
                                    <li>
                                        <div class="message-center notifications position-relative">
                                            <!-- Message -->
                                            <a href="javascript:void(0)"
                                                class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                                <div class="btn btn-danger rounded-circle btn-circle"><i
                                                        data-feather="airplay" class="text-white"></i></div>
                                                <div class="w-75 d-inline-block v-middle ps-2">
                                                    <h6 class="message-title mb-0 mt-1">Luanch Admin</h6>
                                                    <span class="font-12 text-nowrap d-block text-muted">Just see
                                                        the my new
                                                        admin!</span>
                                                    <span class="font-12 text-nowrap d-block text-muted">9:30 AM</span>
                                                </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="javascript:void(0)"
                                                class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                                <span class="btn btn-success text-white rounded-circle btn-circle"><i
                                                        data-feather="calendar" class="text-white"></i></span>
                                                <div class="w-75 d-inline-block v-middle ps-2">
                                                    <h6 class="message-title mb-0 mt-1">Event today</h6>
                                                    <span
                                                        class="font-12 text-nowrap d-block text-muted text-truncate">Just
                                                        a reminder that you have event</span>
                                                    <span class="font-12 text-nowrap d-block text-muted">9:10 AM</span>
                                                </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="javascript:void(0)"
                                                class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                                <span class="btn btn-info rounded-circle btn-circle"><i
                                                        data-feather="settings" class="text-white"></i></span>
                                                <div class="w-75 d-inline-block v-middle ps-2">
                                                    <h6 class="message-title mb-0 mt-1">Settings</h6>
                                                    <span
                                                        class="font-12 text-nowrap d-block text-muted text-truncate">You
                                                        can customize this template
                                                        as you want</span>
                                                    <span class="font-12 text-nowrap d-block text-muted">9:08 AM</span>
                                                </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="javascript:void(0)"
                                                class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                                <span class="btn btn-primary rounded-circle btn-circle"><i
                                                        data-feather="box" class="text-white"></i></span>
                                                <div class="w-75 d-inline-block v-middle ps-2">
                                                    <h6 class="message-title mb-0 mt-1">Pavan kumar</h6> <span
                                                        class="font-12 text-nowrap d-block text-muted">Just
                                                        see the my admin!</span>
                                                    <span class="font-12 text-nowrap d-block text-muted">9:02 AM</span>
                                                </div>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link pt-3 text-center text-dark" href="javascript:void(0);">
                                            <strong>Check all notifications</strong>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- End Notification -->
                        <!-- ============================================================== -->
                        <!-- create new -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i data-feather="settings" class="svg-icon"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </li>
                        <li class="nav-item d-none d-md-block">
                            <a class="nav-link" href="javascript:void(0)">
                                <div class="customize-input">
                                    <select
                                        class="custom-select form-control bg-white custom-radius custom-shadow border-0">
                                        <option selected>BR</option>
                                        <option value="1">ES</option>
                                        <option value="2">EN</option>
                                    </select>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-end">
                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                        <li class="nav-item d-none d-md-block">
                            <a class="nav-link" href="javascript:void(0)">
                                <form>
                                    <div class="customize-input">
                                        <input class="form-control custom-shadow custom-radius border-0 bg-white"
                                            type="search" placeholder="Pesquisar" aria-label="Search">
                                        <i class="form-control-icon" data-feather="search"></i>
                                    </div>
                                </form>
                            </a>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <img src="../assets/images/users/profile-pic.jpg" alt="user" class="rounded-circle"
                                    width="40">
                                <span class="ms-2 d-none d-lg-inline-block"><span>Hello,</span> <span
                                        class="text-dark">Ruan Rosa</span> <i data-feather="chevron-down"
                                        class="svg-icon"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-right user-dd animated flipInY">
                                <a class="dropdown-item" href="javascript:void(0)"><i data-feather="user"
                                        class="svg-icon me-2 ms-1"></i>
                                    My Profile</a>
                                <a class="dropdown-item" href="javascript:void(0)"><i data-feather="credit-card"
                                        class="svg-icon me-2 ms-1"></i>
                                    My Balance</a>
                                <a class="dropdown-item" href="javascript:void(0)"><i data-feather="mail"
                                        class="svg-icon me-2 ms-1"></i>
                                    Inbox</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:void(0)"><i data-feather="settings"
                                        class="svg-icon me-2 ms-1"></i>
                                    Account Setting</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:void(0)"><i data-feather="power"
                                        class="svg-icon me-2 ms-1"></i>
                                    Logout</a>
                                <div class="dropdown-divider"></div>
                                <div class="pl-4 p-3"><a href="javascript:void(0)" class="btn btn-sm btn-info">View
                                        Profile</a></div>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar" data-sidebarbg="skin6">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="index.php"
                                aria-expanded="false"><i data-feather="home" class="feather-icon"></i><span
                                    class="hide-menu">Dashboard</span></a></li>
                        <li class="list-divider"></li>
                        <li class="nav-small-cap"><span class="hide-menu">FINANCEIRO</span></li>

                        <li class="sidebar-item"> <a class="sidebar-link" href="pagamentos.php"
                                aria-expanded="false"><i data-feather="tag" class="feather-icon"></i><span
                                    class="hide-menu">Pagamentos
                                </span></a>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link" href="payment-do.php"
                                aria-expanded="false"><i data-feather="tag" class="feather-icon"></i><span
                                    class="hide-menu">Qrcodes Gerados
                                </span></a>
                        </li>
                        

                        <li class="list-divider"></li>
                        <li class="nav-small-cap"><span class="hide-menu">GESTÃO</span></li>
                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="users.php"
                                aria-expanded="false"><i data-feather="sidebar" class="feather-icon"></i><span
                                    class="hide-menu">Usuários
                                </span></a>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="afiliados.php"
                                aria-expanded="false"><i data-feather="sidebar" class="feather-icon"></i><span
                                    class="hide-menu">Afiliados
                                </span></a>
                        </li>


                        
                        
                        <li class="list-divider"></li>
                        <li class="nav-small-cap"><span class="hide-menu">Authentication</span></li>

                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="create-user.php"
                                aria-expanded="false"><i data-feather="lock" class="feather-icon"></i><span
                                    class="hide-menu">Create User
                                </span></a>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="user-management.php"
                                aria-expanded="false"><i data-feather="lock" class="feather-icon"></i><span
                                    class="hide-menu">Gestão Afiliados
                                </span></a>
                        </li>

                       

                        
                        <li class="list-divider"></li>
                        <li class="nav-small-cap"><span class="hide-menu">Extra</span></li>
                        
                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="user-logout.php"
                                aria-expanded="false"><i data-feather="log-out" class="feather-icon"></i><span
                                    class="hide-menu">Logout</span></a></li>
                                    
                                   
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-7 align-self-center">
                        <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Usuários</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item"><a href="index.php" class="text-muted">Home</a></li>
                                    <li class="breadcrumb-item text-muted active" aria-current="page">Usuários</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-5 align-self-center">
                        <div class="customize-input float-end">
                           
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- basic table -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                     
                                    <h4 class="card-title">Qrcodes Gerados</h4>
                                    <h6 class="card-subtitle">Setup das principais informações dos qrcodes gerados. 
                                    </h6>
                                    <div class="table-responsive">
                                        
                                        <table id="zero_config" class="table border table-striped table-bordered text-nowrap">
                                            <thead>
                                                <tr>
                                                <th>ID</th>
                                                        <th data-order="desc">Nome</th>
                                                            <th data-order="desc">Valor</th>

                                                    <th>Valor</th>
                                                </tr>
                                                                                            
        </thead>
                                            <tbody>
                                               

                              <?php
                                // Conexão com o banco de dados (substitua as credenciais conforme necessário)
                                require('../config.php');
                                $conn = new mysqli("$host", "$usuario", "$senhaDB", "$banco");
                                
                                // Verifica a conexão
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }
                                
                                $sql = "SELECT transaction_id, due, name, amount FROM unprocessed_deposits";
                                $result = $conn->query($sql);
                                
                                // Verifica se há resultados
                                if ($result->num_rows > 0) {
                                    // Saída de dados de cada linha
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row['transaction_id'] . "</td>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['due'] . "</td>";
                                        echo "<td>" . $row['amount'] . "</td>";
                                        echo "</tr>";
                                    }
                                    // Fecha a conexão com o banco de dados após o loop
                                    $conn->close();
                                } else {
                                    echo "Não há resultados.";
                                }
                                ?>

                                            </tbody>

                                            <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                        <th data-order="desc">Nome</th>
                                                            <th data-order="desc">Valor</th>

                                                    <th>Valor</th>
                                                    </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                        </div>
                        <br>
                        <div class="card-body">

                                <div class="row">
                                        <!-- Column -->
                                        <div class="col-md-6 col-lg-3 col-xlg-3">
                                            <div class="card card-hover">
                                                <div class="p-2 bg-primary text-center">
                                                    <h1 class="font-light text-white">R$<?php echo $totalQrcodes; ?></h1>
                                                    <h6 class="text-white">Todos os Qrcodes Gerados</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Column -->
                                        <div class="col-md-6 col-lg-3 col-xlg-3">
                                            <div class="card card-hover">
                                                <div class="p-2 bg-cyan text-center">
                                                    <h1 class="font-light text-white">R$<?php echo $totalQrcodesPagos; ?></h1>
                                                    <h6 class="text-white">Todos os Qrcodes Pagos</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Column -->
                                       
                                        <!-- Column -->
                                        
                                        <!-- Column -->
                                    </div>

                                 
                
                
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center text-muted">
                All Rights Reserved by Revvo Digital. Developed by <a
                    href="https://revvopublicidade.com.br/">Revvo Digital</a>.
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const dataSolicitacaoCells = document.querySelectorAll('.data-solicitacao'); // ajuste a classe conforme necessário

        dataSolicitacaoCells.forEach(cell => {
            const date = new Date(cell.innerText);
            const formattedDate = `${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear()}`;
            cell.innerText = formattedDate;
        });
    });
</script>

    
    <script>
    $(document).ready(function () {
        $('#zero_config, #depositos_config').DataTable();
    });
</script>


    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- apps -->
    <!-- apps -->
    <script src="../dist/js/app-style-switcher.js"></script>
    <script src="../dist/js/feather.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="../assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="../assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <!-- themejs -->
    <!--Menu sidebar -->
    <script src="../dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="../dist/js/custom.min.js"></script>
    <!--This page plugins -->
    <script src="../assets/extra-libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../assets/extra-libs/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
    <script src="../dist/js/pages/datatable/datatable-basic.init.js"></script>
</body>

</html>
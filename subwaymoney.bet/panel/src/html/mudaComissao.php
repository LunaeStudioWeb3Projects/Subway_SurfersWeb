<?php

require('../config.php');
$conn = new mysqli("$host", "$usuario", "$senhaDB", "$banco");
        
    // Verifica a conex達o
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $id = $_GET['id'];
    $comissao = $_GET['comissao'];
    
    $sql = "UPDATE users SET comissaoAfiliado = $comissao WHERE id = $id";
    $result = $conn->query($sql);
    
    echo "<script>";
    echo "location.href = './user-management.php'";
    echo "</script>";
?>
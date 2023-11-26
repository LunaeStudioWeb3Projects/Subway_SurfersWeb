<?php

require('../config.php');
$conn = new mysqli("$host", "$usuario", "$senhaDB", "$banco");
        
    // Verifica a conex達o
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $id = $_GET['id'];
    $saldo = $_GET['saldo'];
    
    $sql = "UPDATE users SET demo_balance = $saldo WHERE id = $id";
    $result = $conn->query($sql);
    
    echo "<script>";
    echo "location.href = './user-management.php'";
    echo "</script>";
?>
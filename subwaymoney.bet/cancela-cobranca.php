<?php
    ob_start();
    session_start();

    $_SESSION['naoPago'] = true;
    $_SESSION['pix'] = null;
    $_SESSION['reference_code'] = null;

    header('Location: deposit');
    exit();
?>
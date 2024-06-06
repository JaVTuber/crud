<?php
    session_start();

    if (!isset($_SESSION['iniSes'])) {
        $_SESSION['iniSes'] = false; // No ha iniciado sesión por defecto
    }

    if (!isset($_SESSION['emp'])) {
        $_SESSION['emp'] = false; // No es empleado por defecto
    }

    if (!isset($_SESSION['adm'])) {
        $_SESSION['adm'] = false; // No es administrador por defecto
    }

    if (!isset($_SESSION['usuario'])) {
        $_SESSION['usuario'] = '';
    }

    if (!isset($_SESSION['id'])) {
        $_SESSION['id'] = '';
    }

    $_SESSION['header'] = "From: rc533191@gmail.com" . "\r\n" . "Reply-to: rc533191@gmail.com" . "\r\n" . "X-Mailer: PHP/" . phpversion();
?>

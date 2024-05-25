<?php
    include('vars.php');
    $_SESSION['iniSes'] = false;
    session_destroy();
    header('Location: ../login.php');
    exit();
?>

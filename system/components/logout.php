<?php
    session_start();
    if (!isset($_SESSION["isLogged"])) {
        header("Location: /login");
    }
    $_SESSION['isLogged'] = '';
    $_SESSION['id'] = '';
    header('Location: /login');
?>
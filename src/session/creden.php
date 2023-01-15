<?php
session_start();
if ($_POST['login']) {
    $_SESSION['login'] = $_POST['login'];
    $_SESSION['secretKey'] = $_POST['secretKey'];
    $_SESSION['idorden'] = null;
    //echo 'toma';
    header('Location: /efectivo');
} else {
    header('Location: /efectivo');
}

?>

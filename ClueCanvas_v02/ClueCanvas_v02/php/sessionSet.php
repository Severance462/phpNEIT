<?php

session_start();

if ((empty($_SESSION['game'])) ||
    (empty($_SESSION['players']))) {
    header('Location: sessionInit.php');
}

if (!empty($_POST['game']) && !empty($_POST['players'])) {
    $_SESSION['game'] = json_decode($_POST['game']);
    $_SESSION['players'] = json_decode($_POST['players']);

    echo '<pre>', print_r($_SESSION['game']), '</pre>';
    echo '<pre>', print_r($_SESSION['players']), '</pre>';
}

header('Location: ./index.php');

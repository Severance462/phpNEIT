<?php

session_start();

if ((empty($_SESSION['game'])) ||
    (empty($_SESSION['players']))) {
    header('Location: php/sessionInit.php');
}

if(!empty($_SESSION['players'])) {
    $gameData = json_encode($_SESSION['game']);
    $playerData = json_encode($_SESSION['players']);
}
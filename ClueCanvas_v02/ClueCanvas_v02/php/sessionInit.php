<?php

// --------------------------------------------------------------------------------------
// Start Session
// --------------------------------------------------------------------------------------

//session_start();

// Game session
//$_SESSION['game'] = [
//    'gameId' => 1,
//    'numPlayers' => 4,
//    'turn' => 1
//];

// Replace hard coded names and characters with $_POST data from start up form.
// Preferably replace theses repeated lines with a function and for loop.

$_SESSION['players'] = array();
$_SESSION['players'][] = initPlayer('Bryce', 'Miss Scarlet');
$_SESSION['players'][] = initPlayer('John', 'Mr Green');
$_SESSION['players'][] = initPlayer('Justin', 'Mrs Peacock');
$_SESSION['players'][] = initPlayer('Ryan', 'Colonel Mustard');
$_SESSION['players'][] = initPlayer('Angie', 'Professor Plum');

// Redirect to showSession.php to show the $_SESSION Array
//header('Location: ../index.php');

// --------------------------------------------------------------------------------------
// Init Functions
// --------------------------------------------------------------------------------------

function initPlayer($name, $character) {
    $data = initLocation($character);
    $player['name'] = $name;
    $player['character'] = $character;
    $player['x'] = $data[0]['x'];
    $player['y'] = $data[0]['y'];
    $player['lastX'] = $data[0]['x'];
    $player['lastY'] = $data[0]['y'];
    $player['color'] = $data[2];
    $player['move'] = 'false';
    $player['moved'] = 'false';
    $player['roll'] = 0;
    $player['room'] = $data[1];
    $player['moves'] = $data[0];
    $player['active'] = 'true';

    return $player;
}

function initLocation($character) {
    $coords = array();
    $room = '';
    $color = '';
    switch ($character) {
        case 'Miss Scarlet':
            $coords = ['x' => 16, 'y' => 0];
            $room = 'Ballroom';
            $color = 'red';
            break;
        case 'Mr Green':
            $coords = ['x' => 18, 'y' => 16];
            $room = 'Hall';
            $color = 'green';
            break;
        case 'Mrs Peacock':
            $coords = ['x' => 16, 'y' => 18];
            $room = 'Hall';
            $color = 'blue';
            break;
        case 'Colonel Mustard':
            $coords = ['x' => 0, 'y' => 16];
            $room = 'Billiard Room';
            $color = 'yellow';
            break;
        case 'Professor Plum':
            $coords = ['x' => 0, 'y' => 9];
            $room = 'Dining Room';
            $color = 'purple';
            break;
        case 'Mrs White':
            $coords = ['x' => 9, 'y' => 0];
            $room = 'Conservatory';
            $color = 'white';
            break;
    }

    return [$coords, $room, $color];
}
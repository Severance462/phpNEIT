<?php
//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

//==================
// Purpose:
//==================
// - Returns an array that is used to know player rotation.

//==================
// Arguments:
//==================
// numPlayers       Total number of players in the current
//                  game.
// currentTurn      Whose turn it currently is. 1 for P1, 2
//                  for P2, etc.

//==================
// Example:
//==================
// If six players are playing and it is currently P1's turn
// this function will return [ 2, 3, 4, 5, 6, 1 ]. Because
// this would be the order in which suggestion would be
// checked.

function getCurrentPlayerOrder($numPlayers, $currentTurn) {
    $order = array();
    $nextTurn = $currentTurn + 1;

    if ($nextTurn > $numPlayers) {
        $nextTurn = 1;
    }

    for ($i = $nextTurn; $i <= $numPlayers; ++$i) {
        $order[] = $i;
    }

    if (count($order) !== $numPlayers) {
        for ($i = 1; $i <= $currentTurn; ++$i) {
            $order[] = $i;
        }
    }


    return $order;
}
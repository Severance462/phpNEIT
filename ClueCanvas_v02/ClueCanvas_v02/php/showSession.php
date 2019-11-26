<?php

session_start();

// Print Players Array
print_r($_SESSION['players']);
echo '<br><br><br>';

// Print Player 1 Array;
print_r($_SESSION['players'][0]);
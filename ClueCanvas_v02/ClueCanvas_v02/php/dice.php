<?php

$dice = array();
if (!empty($_POST['roll'])) {
    $dice['a'] = rand(1, 6);
    $dice['b'] = rand(1, 6);
    $_POST['roll'] = null;
} else {
    $dice['a'] = '';
    $dice['b'] = '';
}
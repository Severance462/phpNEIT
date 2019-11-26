<?php

function getChecklist($type) {
    $players = [
        'Green',
        'Mustard',
        'Peacock',
        'Plum',
        'Scarlet',
        'White'
    ];

    $weapons = [
        'Candlestick',
        'Dagger',
        'Lead Pipe',
        'Pistol',
        'Rope',
        'Wrench'
    ];

    $rooms = [
        'Bathroom',
        'Bedroom',
        'Courtyard',
        'Dining Room',
        'Game Room',
        'Garage',
        'Kitchen',
        'Living Room',
        'Office'
    ];

    $html = '';
    switch ($type) {
        case 'players':
            $html = createChecklist($players);
            break;
        case 'weapons':
            $html = createChecklist($weapons);
            break;
        case 'rooms':
            $html = createChecklist($rooms);
            break;
    }
    return $html;
}

function createChecklist($data) {
    $n = count($data);

    $html = '';
    for($i = 0; $i < $n; ++$i) {
        $html .= '<tr><td>' . $data[$i] . '</td>';
        $html .= '<td></td><td></td><td></td>';
        $html .= '<td></td><td></td><td></td></tr>';
    }
    return $html;
}
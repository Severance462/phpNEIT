<?php



function getRecord($gameId, $playerId) {
    $db = getDatabase();
    $qry  = "SELECT * FROM cluecards WHERE playerID";
    $qry .= " LIKE $playerId AND gameId LIKE $gameId";
    $sql = executeQuery($db, $qry);
    return $sql->fetchALL(PDO::FETCH_ASSOC);
}

function createTables($gameId, $playerId) {
    $notebook = getRecord($gameId, $playerId);
    $notebook = convertTo2dIndexedArray($notebook);

    $suspects = [
        'Mr Green',
        'Colonel Mustard',
        'Mrs Peacock',
        'Professor Plum',
        'Miss Scarlet',
        'Mrs White',
    ];

    $weapons = [
        'Candlestick',
        'Dagger',
        'Lead Pipe',
        'Pistol',
        'Rope',
        'Wrench',
    ];

    $rooms = [
        'Ballroom',
        'Billiard Room',
        'Conservatory',
        'Dining Room',
        'Hall',
        'Kitchen',
        'Library',
        'Lounge',
        'Study',
    ];

    $html = 'Player' . $playerId;
    $html .= createTable('Suspects', $suspects, $notebook,13, 17);
    $html .= createTable('Weapons', $weapons, $notebook, 19, 24);
    $html .= createTable('Rooms', $rooms, $notebook, 4, 12);
    return $html;
}

function convertTo2dIndexedArray($oldArr) {
    $count = count($oldArr);
    $newArr = array();
    for ($i = 0; $i < $count; ++$i) {
        $tempArr = array();
        foreach ($oldArr[$i] as $index) {
            $tempArr[] = $index;
        }
        $newArr[] = $tempArr;
    }
    return $newArr;
}

function createTable($title, $labels, $notebook, $start, $end) {
    $numBooks = count($notebook);
    $html = '';
    $html .= '<div class="row">';
    $html .= '<div class="col-12">';
    $html .= '<table id="table-'.$title.
        '"class="table table-hover table-sm table-striped">';
    $html .= '<thead>';
    $html .= '<tr>';
    $html .= '<th scope="col" style="width: 40%;">'. $title .'</th>';
    for ($k = 1; $k <$numBooks+1; ++$k)
    {
        $html .= '<th scope="col" id="th-p'.$k.'">P'.$k.'</th>';
    }
    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody>';
    $html .= createTableBody($notebook, $labels, $start, $end);
    $html .= '</tbody>';
    $html .= '</table>';
    $html .= '</div>';
    $html .= '</div>';

    return $html;
}

function createTableBody($notebook, $labels, $start, $end) {
    $numBooks = count($notebook);
    $html = '';
    for ($y = $start; $y <= $end; ++$y) { // Number of Rows
        $html .= '<tr>';
        $html .= '<td>' . $labels[$y-$start] . '</td>';
        for ($x = 0; $x < $numBooks; ++$x) { // Number of Columns
            if ($notebook[$x][$y] == ($x+1)) {
                $html .= '<td><i class="fa fa-check" style="color: green"></i></td>';
            } else if ($notebook[$x][$y] !== null) {
                $html .= '<td><i class="fa fa-close" style="color: red"></i></td>';
            } else {
                $html .= '<td></td>';
            }
        }
        $html .= '</tr>';
    }
    return $html;
}
?>



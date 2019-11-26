<?php

include_once('dbConnect.php');
include_once('sql.php');
$db = getDatabase();
$gameId = 2;
$html = getCards($db);

//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

// Inserts records into card table
function insertCardData($db, $gameId) {
    $fields = [
        ':playerId',
        ':gameId',
        ':ballroom',
        ':billiard_room',
        ':conservatory',
        ':dining_room',
        ':hall',
        ':kitchen',
        ':library',
        ':living_room',
        ':lounge',
        ':study',
        ':mr_green',
        ':colonel_mustard',
        ':mrs_peacock',
        ':professor_plum',
        ':miss_scarlet',
        ':mrs_white',
        ':candlestick',
        ':dagger',
        ':lead_pipe',
        ':pistol',
        ':rope',
        ':wrench'
    ];

    for ($y = 0; $y < 7; ++$y) {
        $n = count($fields);
        $values = array();
        $values[] = $y;
        $values[] = $gameId;
        for($x = 0; $x < $n - 3; ++$x) {
            $values[] = rand(1, 6);
        }

        $qry = 'INSERT INTO cluecards VALUES(null, :playerId, :gameId, ';
        $qry .= ' :ballroom, :billiard_room, :conservatory, :dining_room, ';
        $qry .= ':hall, :kitchen, :library, :living_room, :lounge, :study, ';
        $qry .= ':mr_green, :colonel_mustard, :mrs_peacock, :professor_plum, ';
        $qry .= ':miss_scarlet, :mrs_white, :candlestick, :dagger, :lead_pipe, ';
        $qry .= ':pistol, :rope, :wrench)';

        runQueryBind($db, $qry, $fields, $values);
    }
}

function getCards($db) {

    $qry = 'SELECT * FROM cluecards WHERE playerId=0 AND gameId=2';
    $sql = runQuery($db, $qry);
    $result = $sql->fetch(PDO::FETCH_ASSOC);

    $fields = '<table>';
    foreach ($result as $key => $value) {
        $fields .= '<tr><td>' . $key . '</td>';
        $fields .= '<td>' . $value . '</td></tr>';
    }

    return $fields;
}

//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

// Returns a string of table body html and message data
function getData($sql)
{
    $data = array();
    if($sql->rowCount() > 0) {
        $data = $sql->fetchAll(PDO::FETCH_ASSOC);
    }else {
        $data = 'Did not work';
    }

    return $data;
}

echo $html;
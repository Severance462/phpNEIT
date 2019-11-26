<?php
/**
 * Function to extablish a databse connection
 *
 * @return PDO Object
 */
function getDatabase() {
    $dbname="se266_john";
    $username="se266_john";
    $pwd="1434115"; // your student id WITHOUT the zeroes

    if (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] == 'ict.neit.edu') {
        $config = array(
        'DB_DNS' => "mysql:host=localhost;port=5500;dbname=$dbname;",
        'DB_USER' => $username,
        'DB_PASSWORD' => $pwd
    );
    } else { //local
        //$username="root";
		//$pwd="";
        $config = array(
            'DB_DNS' => "mysql:host=localhost;port=3306;dbname=$dbname;",
            'DB_USER' => $username,
            'DB_PASSWORD' => $pwd
        );
    }


        $db = new PDO($config['DB_DNS'], $config['DB_USER'], $config['DB_PASSWORD']);

    return $db;
}




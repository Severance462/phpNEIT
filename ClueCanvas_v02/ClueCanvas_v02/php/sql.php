<?php

//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

// This page holds all of the functions that work directly with mySQL

//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

// Creates connection to the database.
function dbConn() {
    $dbname="se266_john";
    $username="se266_john";
    $pwd="11434115"; // your student id WITHOUT the zeroes

    if (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] == 'ict.neit.edu') {
        $config = array(
            'DB_DNS' => "mysql:host=localhost;port=5500;dbname=$dbname;",
            'DB_USER' => $username,
            'DB_PASSWORD' => $pwd
        );
    } else { //local
        $pwd="123456789";
        $config = array(
            'DB_DNS' => "mysql:host=localhost;port=3306;dbname=$dbname;",
            'DB_USER' => $username,
            'DB_PASSWORD' => $pwd
        );
    }


    try {
        /* Create a Database connection and
         * save it into the variable */
        $db = new PDO($config['DB_DNS'], $config['DB_USER'], $config['DB_PASSWORD']);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    } catch (Exception $ex) {
        /* If the connection fails we will close the
         * connection by setting the variable to null */
        $db = null;
    }

    return $db;
}

//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

// Returns data with results from query of the database table.
function runQuery($db, $query)
{
    try {
        $sql = $db->prepare($query);
        $sql->execute();
        return $sql;
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

// Performs action on the database table based on specified query.
// Parameters are bound using a for loop.
function runQueryBind($db, $qry, $fields, $values) {
    $count = count($fields);

    try {
        $sql = $db->prepare($qry);
        for ($i = 0; $i < $count; ++$i) {
            $sql->bindParam($fields[$i], $values[$i]);
        }
        $sql->execute();
    }
    catch (PDOException $e)
    {
        die("Error: " . $e->getMessage());
    }
}

//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
function executeQuery($db, $qry) {
    $query = $db->prepare($qry);
    $query->execute();
    return $query;
}

function executeQueryWithBind($db, $qry, $value) {
    $query = $db->prepare($qry);
    $bind = substr($qry, strpos($qry, ':'));
    $bind = substr($bind, 0, strpos($bind, ','));
    $query->bindParam($bind, $value);
    $query->execute();
    return $query;
}

function executeQueryWithBinds($db, $qry, $values) {
    $query = $db->prepare($qry);
    foreach ($values as $value) {
        $bind = substr($qry, strpos($qry, ':'));
        echo 'Bnd: ' . $bind . '<br>';
        $qry = $bind;
        $bind = substr($bind, 0, strpos($bind, ','));
        $qry = substr($qry, strpos($qry, ',') + 1);
        echo 'Bind: ' . $bind . '<br>';
        echo 'Value: ' . $value . '<br>';
        $query->bindParam($bind, $value);
    }
    $query->execute();
    return $query;
}

function selectAllStatement($table, $where) {
    $query = "SELECT * FROM $table WHERE $where";
    return $query;
}

function insertStatement($table, $columns, $values) {
    $query = "INSERT INTO $table ($columns) ";
    $query .= "VALUES ($values)";
    return $query;
}

function updateStatement($table, $set, $where) {
    $query = "UPDATE $table SET $set WHERE $where";
    return $query;
}

?>
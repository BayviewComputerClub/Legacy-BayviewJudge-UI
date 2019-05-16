<?php
// Helpers.

// Returns an array of the user (by username)
function getUserByUsername($username) {
    $config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");
    // Create connection object
    $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //$username = $conn->real_escape_string($_POST['username']);

    $query = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($query);

    return $result->fetch_assoc();
}

function getUserByID($id) {
    $config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");
    // Create connection object
    $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT * FROM users WHERE id='$id'";
    $result = $conn->query($query);

    return $result->fetch_assoc();
}

function getUsersList() {
    $config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");
    // Create connection object
    $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $query = "SELECT * FROM users ORDER BY points DESC";
    $result = $conn->query($query);


    $userArray = array(); // make a new array to hold all your data


    $index = 0;
    while($row = $result->fetch_assoc()){ // loop to store the data in an associative array.
        $userArray[$index] = $row;
        $index++;
    }

    return $userArray;
}

function computeScoreByID($id) {
    $config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");
    // Create connection object
    $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT sum(points) FROM submissions WHERE user_id=$id";
    $result = $conn->query($query);

    $points = $result->fetch_assoc()['sum(points)'];

    // HACK: update the users points to match the computed points.
    // Basically the first time you view the leaderboard the order is wrong, but in theory
    // is fine the next reload. This could lead to discrepancies but it should be fine.
    $query = "UPDATE users SET
                 points=$points
                 WHERE id=$id";
    $conn->query($query);

    return $points;
}

function getUserSubmissionsByID($id) {
    $config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");
    // Create connection object
    $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT * FROM submissions WHERE user_id=$id";
    $result = $conn->query($query);

    $problems=array();
    while ($row = $result->fetch_assoc()) {
        array_push($problems,$row);
    }


    return $problems;
}

?>
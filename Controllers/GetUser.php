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

    $username = $conn->real_escape_string($_POST['username']);

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

    $username = $conn->real_escape_string($_POST['username']);

    $query = "SELECT * FROM users WHERE id='$id'";
    $result = $conn->query($query);

    return $result->fetch_assoc();
}

?>
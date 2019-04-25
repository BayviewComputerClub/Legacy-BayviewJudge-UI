<?php
function getUserByUsername($username) {
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

?>
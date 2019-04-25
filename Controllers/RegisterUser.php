<?php
$config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-head.php");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-foot.php");

// Does the query have data
if(isset($_POST['username'])) {

    // Create connection object
    $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // POST Data (escaped)
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $full_name = $conn->real_escape_string($_POST['full_name']);
    // Hash&Salt the password using bcrypt
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    //TODO check if duplicate username

    $query = "INSERT INTO users (username, password, email, points, full_name, school, profile_desc) VALUES ('$username', '$password', 'john@example.com', 0, 'hi', 'hi2', 'hi')";

    if ($conn->query($query) === TRUE) {
        echo renderPageHead("Registered");
        echo "BayviewJudge - You have been registered!";
        echo renderPageFoot();

    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }

    $conn->close();

} else {
    echo renderPageHead("Error");
    echo "BayviewJudge - Invalid Request";
    echo renderPageFoot();
}
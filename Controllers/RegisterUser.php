<?php
session_start();
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

    // Validate username (alphanumeric only)
    if(!preg_match('/^[A-Za-z0-9._-]+$/', $username)) {
        echo renderPageHead("Registered");
        echo "BayviewJudge - Invalid username, it should be alphanumeric only (dashs and dots allowed).";
        echo renderPageFoot();
        die();
    }

    $email = $conn->real_escape_string($_POST['email']);
    $full_name = $conn->real_escape_string($_POST['full_name']);
    // Hash&Salt the password using bcrypt
    $password = password_hash($_POST['password'], PASSWORD_ARGON2I);

    //TODO check if duplicate username

    $query = "INSERT INTO users (username, password, email, points, full_name, school, profile_desc) VALUES ('$username', '$password', '$email', 0, '$full_name', 'Bayview Secondary School', 'Default User')";

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
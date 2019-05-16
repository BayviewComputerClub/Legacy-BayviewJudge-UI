<?php
session_start();
$config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-head.php");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-foot.php");

include($_SERVER['DOCUMENT_ROOT'] . "/Parts/Helpers.php");

//todo
// Verify the hash from the request to one generated in the db.
if(isset($_GET['email']) && isset($_GET['id'])) {
    $email = $_GET['email'];
    $verify_id = $_GET['id'];

    // Create connection object
    $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT * from users WHERE email='$email'";
    $result = $conn->query($query)->fetch_assoc();

    if($verify_id = $result['verify_id']) {
        echo renderPageHead('Verified!');
        echo printCard("Your email has been verified!");
        echo renderPageFoot();
    } else {
        echo renderPageHead('Verify Error');
        echo printCard("This verify request is not valid.");
        echo renderPageFoot();
    }
} else {
    echo renderPageHead('Error');
    echo printCard("This request is not valid.");
    echo renderPageFoot();
}

?>
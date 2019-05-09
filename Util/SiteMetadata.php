<?php
function getMetaValue($name) {
    $config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");
    // Create connection object
    $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT content FROM site_meta WHERE name='$name'";
    $result = $conn->query($query);
    return $result->fetch_assoc()['content'];
}
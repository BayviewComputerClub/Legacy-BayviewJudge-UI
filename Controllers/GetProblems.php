<?php

// Returns an array of problems.
function getProblems() {
    $config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");
    // Create connection object
    $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $conn->real_escape_string($_POST['username']);

    $query = "SELECT * FROM problems";
    $result = $conn->query($query);


    $problemArray = array(); // make a new array to hold all your data


    $index = 0;
    while($row = $result->fetch_assoc()){ // loop to store the data in an associative array.
        $problemArray[$index] = $row;
        $index++;
    }

    return $problemArray;
}

function getProblemByID($id) {
    foreach(getProblems() as $problem) {
        if($problem['id'] == $id) {
            return $problem;
        }
    }
    return "";
}
?>

<?php
$config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-head.php");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-foot.php");

include($_SERVER['DOCUMENT_ROOT'] . "/Controllers/GetUser.php");

// Does the query have data
if (isset($_POST['username'])) {



    // POST Data (escaped)
    $username = $conn->real_escape_string($_POST['username']);

    $password = $_POST['password'];


    // Verify the user's password!



    $conn->close();

} else {
    echo renderPageHead("Error");
    echo "BayviewJudge - Invalid Login Request";
    echo renderPageFoot();
}
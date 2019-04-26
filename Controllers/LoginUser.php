<?php
session_start();

$config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-head.php");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-foot.php");

include($_SERVER['DOCUMENT_ROOT'] . "/Controllers/GetUser.php");

// Does the query have data
if (isset($_POST['username'])) {

    // POST Data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verify the user's password!
    $user = getUserByUsername($username);

    if(password_verify($password, $user['password'])) {
        // The password matches, set the session.
        $_SESSION['username'] = $user['username'];
        $_SESSION['id'] = $user['id'];

        echo renderPageHead("Login");
        echo "BayviewJudge - You are now logged in!";
        echo renderPageFoot();

    } else {
        echo renderPageHead("Error");
        echo "BayviewJudge - Invalid Username or Password";
        echo renderPageFoot();
    }


} else {
    echo renderPageHead("Error");
    echo "BayviewJudge - Invalid Login Request";
    echo renderPageFoot();
}
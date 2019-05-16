<?php
session_start();
function renderPageHead($title) {
    $config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");
    $pageRoot = $config['page_root'];
    $username = $_SESSION['username'];

    $helloMsg = "";
    $authBtns = "<li><a href=\"$pageRoot/Auth/Login.php\">Login</a></li><li><a href=\"$pageRoot/Auth/Register.php\">Register</a></li>";

    if(isset($_SESSION['username'])) {
        $helloMsg = "Hello, " . $username . "!";
        $authBtns = "<li><a href=\"$pageRoot/Auth/Logout.php\">Logout</a></li>";
    }

    return <<<HTML
<!DOCTYPE html>
<html>
    <head>
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="$pageRoot/Assets/materialize/css/materialize.min.css"  media="screen,projection"/>
    
        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <style>
            body {
                display: flex;
                min-height: 100vh;
                flex-direction: column;
            }
            
            main {
                flex: 1 0 auto;
            }
        </style>
        
        <title>$title - BayviewJudge</title>
    </head>
    
    <body>
        
        <nav>
            <div class="nav-wrapper">
                <a href="$pageRoot/" class="brand-logo" style="padding-left: 20px">λ ~/Bayview Judge</a>
                <ul id="nav-mobile" class="right hide-on-med-and-down" style="padding-right: 20px">
                    
                    <li><a href="$pageRoot/Problems/ViewProblems.php">View Problems</a></li>
                    <li><a href="$pageRoot/Leaderboard">Leaderboard</a></li>
                    $authBtns
                    <li><a href="$pageRoot/About.php">About</a></li>
                    <li><strong>|  $helloMsg</strong></li>
                </ul>
            </div>
        </nav>
        <main>
            <div class="container">
HTML;

}
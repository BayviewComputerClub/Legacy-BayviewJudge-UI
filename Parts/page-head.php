<?php
session_start();
function renderPageHead($title) {
    $config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");
    $pageRoot = $config['page_root'];
    $username = $_SESSION['username'];
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
        
        <title>$title - BayviewJudge</title>
    </head>
    
    <body>
    
        <nav>
            <div class="nav-wrapper">
                <a href="$pageRoot/" class="brand-logo">Logo</a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    
                    <li><a href="$pageRoot/Problems">View Problems</a></li>
                    <li><a href="$pageRoot/Auth/Login.php">Login</a></li>
                    <li><a href="$pageRoot/Auth/Register.php">Register</a></li>
                    <li>Hello, $username</li>
                </ul>
            </div>
        </nav>
        <div class="container">
HTML;

}
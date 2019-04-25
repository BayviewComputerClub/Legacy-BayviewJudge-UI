<?php
function renderPageHead($title) {
    $pageRoot = $config['page_root'];
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
                <a href="#" class="brand-logo">Logo</a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a href="sass.html">Contest - View Problems</a></li>
                    <li><a href="badges.html">Login</a></li>
                    <li><a href="collapsible.html">Register</a></li>
                </ul>
            </div>
        </nav>
        <div class="container">
HTML;

}
<?php

session_start();
$config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-head.php");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-foot.php");

include($_SERVER['DOCUMENT_ROOT'] . "/Util/SiteMetadata.php");

// User must be logged in.
/*
if(!isset($_SESSION['id'])) {
    header("Location: ".$config['page_root']);
    die();
}*/


?>
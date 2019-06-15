<?php
$config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");
session_start();
session_destroy();
//header("Location: ".$config['page_root']);
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-head.php");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-foot.php");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/Helpers.php");

echo renderPageHead("Logged out | BayviewJudge");
$home = $config['page_root'];
echo printCard("<strong>You have been logged out!</strong> <br /> <a href='$home' class='btn'>Back to Home</a> ");
echo renderPageFoot();

die();
?>
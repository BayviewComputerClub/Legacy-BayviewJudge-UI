<?php
$config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");
session_start();
session_destroy();
header("Location: ".$config['page_root']);
die();
?>
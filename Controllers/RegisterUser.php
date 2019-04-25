<?php
$config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-head.php");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-foot.php");

// Does the query have data
if(isset($_POST['username'])) {

} else {
    echo renderPageHead("Error");
    echo "BayviewJudge - Invalid Request";
    echo renderPageFoot();
}
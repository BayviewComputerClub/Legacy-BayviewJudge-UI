<?php
$config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-head.php");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-foot.php");

echo renderPageHead("Home");
// Page Contents:
?>

    <div class="card blue-grey darken-1">
        <div class="card-content white-text">
            <span class="card-title">BayviewJudge</span>
            <p>I am a very simple card. I am good at containing small bits of information.
                I am convenient because I require little markup to use effectively.</p>
        </div>
        <div class="card-action">
            <a href="#">View Problems</a>
            <a href="#">Register</a>
        </div>
    </div>

<?php
echo renderPageFoot();
?>

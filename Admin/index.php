<?php
session_start();
$config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-head.php");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-foot.php");

// User must be logged in.
if(!isset($_SESSION['id'])) {
    header("Location: ".$config['page_root']);
    die();
}
//todo make sure user is an admin (or http auth or something)


echo renderPageHead("Admin Home");
?>
<div class="card white hoverable">
    <div class="card-content black-text">
        <div class="row">
            <h4>Admin</h4>
            <p>Please be careful!</p>
        </div>
        <div class="row">
            <a class="waves-effect waves-light btn"><i class="material-icons left">cloud</i>Add Problems</a>
            <a class="waves-effect waves-light btn"><i class="material-icons left">cloud</i>Edit Problems</a>
        </div>
    </div>

</div>
<?php
echo renderPageFoot();
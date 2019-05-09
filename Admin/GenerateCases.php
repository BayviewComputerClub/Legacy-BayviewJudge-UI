<?php
session_start();
$config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-head.php");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-foot.php");

include($_SERVER['DOCUMENT_ROOT'] . "/Util/SiteMetadata.php");

// User must be logged in.
if(!isset($_SESSION['id'])) {
    header("Location: ".$config['page_root']);
    die();
}


echo renderPageHead("Site Options - Admin");
?>
<div class="card white hoverable">
    <div class="card-content black-text">
        <div class="row">
            <h4>Generate testcase JSON</h4>
            <p></p>
        </div>
        <div class="row">
            <form class="col s12" action="<?php echo $config['page_root'] ?>/Admin/Controllers/SiteOptionsController.php" method="post">

                <div class="row">
                    <div class="input-field col s12">
                        <p><strong>Homepage Text</strong></p>
                        <textarea id="home_text" name="home_text"><?php echo getMetaValue("home_text"); ?></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <input id="submit" type="submit" class="waves-effect waves-light btn" value="Save">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script></script>
<?php
echo renderPageFoot();
?>

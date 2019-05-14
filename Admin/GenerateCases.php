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

if(isset($_POST['upload'])) {
    $total = count($_FILES['upload']['name']);

    for( $i=0 ; $i < $total ; $i++ ) {

        //Get the temp file path
        $tmpFilePath = $_FILES['upload']['tmp_name'][$i];

        if ($tmpFilePath != ""){
            echo "Path: $tmpFilePath";
        }
    }
} else {

    echo renderPageHead("Site Options - Admin");
    ?>
    <div class="card white hoverable">
        <div class="card-content black-text">
            <div class="row">
                <h4>Generate testcase JSON</h4>
                <p></p>
            </div>
            <div class="row">
                <form class="col s12"
                      action="<?php echo $config['page_root'] ?>/Admin/GenerateCases.php"
                      method="post">

                    <div class="row">
                        <div class="input-field col s12">
                            <p><strong>Input Cases (Multi File Upload)</strong></p>
                            <input name="upload[]" type="file" multiple="multiple"/>
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
}
?>

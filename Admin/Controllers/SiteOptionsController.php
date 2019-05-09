<?php
session_start();
$config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-head.php");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-foot.php");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/Helpers.php");

// User must be logged in.
if(!isset($_SESSION['id'])) {
    header("Location: ".$config['page_root']);
    die();
}

if(isset($_POST['home_text'])) {
    $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $home_text = $conn->real_escape_string($_POST['home_text']);

    $query = "UPDATE site_meta SET 
                     content='$home_text'
              WHERE name='home_text'";

    if ($conn->query($query) === TRUE) {
        echo renderPageHead("Edit Site - Done -");
        echo printCard("BayviewJudge - The site has been edited.");
        ?>
        <a class="waves-effect waves-light btn" href="<?php echo $config['page_root']?>/Admin/index.php"><i class="material-icons left">cloud</i>Admin Home</a>
        <?php
        echo renderPageFoot();

    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    echo 'Invalid request';
}
<?php
session_start();
$config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-head.php");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-foot.php");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/Helpers.php");

if(!isset($_SESSION['id'])) {
    header("Location: ".$config['page_root']);
    die();
}


if(isset($_POST['name'])) {

    $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Grab everything from POST
    $id = $conn->real_escape_string($_POST['id']);
    $name = $conn->real_escape_string($_POST['name']);

    // Details PDF
    $details = "";
    if(isset($_FILES['details'])){
        $target_file = $_SERVER['DOCUMENT_ROOT'] . "/PDF/" . basename($_FILES["details"]["name"]);
        if (move_uploaded_file($_FILES["details"]["tmp_name"], $target_file)) {
            //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
        $details =  $conn->real_escape_string(basename($_FILES["details"]["name"]));
    } else {
        //todo make it so you don't have to reupload the pdf every time.
    }

    $points = $conn->real_escape_string($_POST['points']);
    $timelimit = $conn->real_escape_string($_POST['timelimit']);
    $memlimit = $conn->real_escape_string($_POST['memlimit']);
    $sample_input = $conn->real_escape_string($_POST['sample_input']);
    $sample_output = $conn->real_escape_string($_POST['sample_output']);
    $input = $conn->real_escape_string($_POST['input']);
    $output = $conn->real_escape_string($_POST['output']);

    $query = "UPDATE problems SET 
                    name='$name', 
                    details='$details', 
                    points=$points, 
                    timelimit=$timelimit, 
                    memlimit=$memlimit, 
                    sample_in='$sample_input', 
                    sample_out='$sample_output', 
              WHERE id=$id";

    if ($conn->query($query) === TRUE) {
        echo renderPageHead("Edit Problem - Done -");
        echo printCard("BayviewJudge - The problem has been edited.");
        ?>
        <a class="waves-effect waves-light btn" href="<?php echo $config['page_root']?>/Admin/index.php"><i class="material-icons left">cloud</i>Admin Home</a>
        <?php
        echo renderPageFoot();

    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }

    $conn->close();

} else{
    echo "Invalid Request";
}
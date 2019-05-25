<?php
session_start();
$config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-head.php");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-foot.php");

include($_SERVER['DOCUMENT_ROOT'] . "/Controllers/GetProblems.php");
include($_SERVER['DOCUMENT_ROOT'] . "/Controllers/GetSubmissions.php");

if($_FILES["zip_file"]["name"]) {
    $filename = $_FILES["zip_file"]["name"];
    $source = $_FILES["zip_file"]["tmp_name"];
    $type = $_FILES["zip_file"]["type"];

    $id = $_GET['id'];

    $name = explode(".", $filename);
    $accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
    foreach($accepted_types as $mime_type) {
        if($mime_type == $type) {
            $okay = true;
            break;
        }
    }

    $continue = strtolower($name[1]) == 'zip' ? true : false;
    if(!$continue) {
        $message = "The file you are trying to upload is not a .zip file. Please try again.";
    }

    $target_path = $_SERVER['DOCUMENT_ROOT'] . "/tmp/" . $filename;
    if(move_uploaded_file($source, $target_path)) {
        $zip = new ZipArchive();
        $x = $zip->open($target_path);
        if ($x === true) {
            $zip->extractTo($_SERVER['DOCUMENT_ROOT'] . "/tmp/" . $_GET['id']);
            $zip->close();

            unlink($target_path);
        }
        $message = "Your .zip file was uploaded and unpacked.";
    } else {
        $message = "There was a problem with the upload. Please try again.";
    }

    /* ~~ File Uploaded, parse them into a in_case and out_case objects ~~ */
    $in_cases = array();
    $out_cases = array();

    $basepath = $_SERVER['DOCUMENT_ROOT'] . "/tmp/" . $_GET['id'];

    $num_batches = 0;
    // For now let's assume that there will be a max of 10 batches
    for($i = 0; $i < 10; $i++) {
        if(file_exists($basepath . "/test-" . $i . "-0.in")) {
            $num_batches++;
        } else {
            // We have hit the max number of batches. Exit.
            break;
        }
    }

    // Generate a Batch
    for($x = 0; $x < $num_batches; $x++) {

        $batch  =(object)[];
        $batch->cases = array();
        $batch->points = file_get_contents($basepath . "/" . $x . ".points");

        // For now let's assume that there will be a max of 100 test cases per batch.
        for($i = 0; $i < 100; $i++) {
            if(file_exists($basepath . "/test-" . $x . "-" . $i . ".in")){
                $file = file_get_contents($basepath  ."/test-" . $x . "-" . $i . ".in");
                $batch->cases[$i] = $file;
            } else {
                // we have parsed all the testcases for this batch.
                break;
            }
        }

        $in_cases[$x] = $batch;
    }
    for($x = 0; $x < $num_batches; $x++) { // output cases

        $batch  =(object)[];
        $batch->cases = array();

        // For now let's assume that there will be a max of 100 test cases per batch.
        for($i = 0; $i < 100; $i++) {
            if(file_exists($basepath . "/test-" . $x . "-" . $i . ".out")){
                $file = file_get_contents($basepath  ."/test-" . $x . "-" . $i . ".out");
                $batch->cases[$i] = $file;
            } else {
                // we have parsed all the testcases for this batch.
                break;
            }
        }

        $out_cases[$x] = $batch;
    }

    //var_dump(json_encode($in_cases));

    // Push to the SQL Database

    $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $in_cases_json = $conn->real_escape_string(json_encode($in_cases));
    $out_cases_json = $conn->real_escape_string(json_encode($out_cases));

    $query = "UPDATE problems SET  
                    in_cases='$in_cases_json', 
                    out_cases='$out_cases_json' 
              WHERE id=$id";

    if ($conn->query($query) === TRUE) {
        $message = $message . " Added to the database.";

    } else {
        $message = $message . " Error: " . $query . "<br>" . $conn->error;
    }

    $conn->close();

}
echo renderPageHead("Add Test Data - Admin");
?>

<div class="card white hoverable">
    <div class="card-content black-text">
        <h3>Add Test Data</h3>
        <blockquote>
            Each problem should be in a single zip file. The file will contain .in and .out files representing the input and output cases.
            The Name will be as follows, where x is the batch number and y is the testcase number, starting from 0.
            <br />That is: test-x-y.in test-x-y.out
            <br /><br />
            Ex. test-0-0.in is the first batch, first test case input (Batch 0 is the sample cases always)<br />
            Ex. test-1-3.out is the second batch, fourth test case output<br />
            <br />
            Important! Each zip should also have a x.points file with the number of points assosicated with that batch.<br />
            <br />
            Make sure each .in file should have a corresponding .out file.
        </blockquote>
        <div class="row">
            <h5>Select a problem</h5>
        </div>
        <div class="row">
            <table>
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Points</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>
                <?php
                $problems = getProblems();
                foreach($problems as $problem) {
                    ?>
                    <tr>
                        <td><?php echo $problem['name'] ?></td>
                        <td><?php echo $problem['points'] ?></td>
                        <td><a href="UploadProblemData.php?id=<?php echo $problem['id'] ?>" class="btn waves-effect">Edit Problem</a></td>
                    </tr>
                    <?php
                }
                ?>


                </tbody>
            </table>
        </div>
        <?php
        if(isset($_GET['id'])) {
            // Get problem details.
            $problem = getProblemByID($_GET['id']);

            ?>
            <div class="row">
                <hr />
                <h5>Upload Test Data</h5>
                <?php if($message) echo "<p>$message</p>"; ?>
                <form enctype="multipart/form-data" method="post" action="">
                    <label>Choose a zip file to upload: <input type="file" name="zip_file" /></label>
                    <br />
                    <br />
                    <br />
                    <input type="submit" name="submit" value="Upload" />
                </form>

            </div>
            <?php
        }
        ?>
    </div>
</div>

<?php
echo renderPageFoot();
?>
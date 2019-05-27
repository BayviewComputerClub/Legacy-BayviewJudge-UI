<?php
session_start();

// Please don't yell at me
// This causes things like echo to flush the PHP buffer, so for problems with
// lots of test cases the user can see the "Accepted" come in each test case.
ob_implicit_flush(true);

// Deal with grader hanging
set_time_limit ( 64 );

$config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-head.php");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-foot.php");

// user must be logged in.
if(!isset($_SESSION['id'])) {
    header("Location: ".$config['page_root']);
    die();
}

include($_SERVER['DOCUMENT_ROOT'] . "/Controllers/GetProblems.php");

function judgeSolution($problemID, $userID, $inputCode, $lang, $input, $output, $timelimit) {
    $config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");
    // Submission Request Object
    $data = array(
        'problemID' => $problemID,
        'userID' => $userID,
        'inputCode' => base64_encode($inputCode),
        'lang' => $lang,
        'input' => $input,
        'output' => $output,
        'timelimit' => $timelimit*1000 // Seconds to Milliseconds
    );

    $context = stream_context_create(array(
        'http' => array(
            'method' => 'POST',
            'header' => "Content-Type: application/json\r\n",
            'content' => json_encode($data),
            'ignore_errors' => true // Do not treat error 401 etc as real PHP error
        )
    ));
    // Send the request to the backend, and get the result.
    if(!$response = file_get_contents($config['grader_host'].'/v1/judge-submission', FALSE, $context)) {
        // The response failed for whatever reason.
        die('Internal Error - Bayview Judge');
    }
    // Check for errors
    if($response === FALSE){
        var_dump($response); // For debug only! Remove in production
        die('Internal Error - Bayview Judge');
    }

    return $response;
}

function addSubmissionToSQL($result, $batch, $points, $source, $lang) {
    // AC: Accepted, WA: Wrong Answer, TLE: Time Limit Exceeded, CE: Compile Error

    $config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");

    $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $user_id = $_SESSION['id'];
    $problem_id = $_POST['id'];

    // First delete any old submissions.
    $query = "DELETE FROM submissions WHERE user_id=$user_id AND problem_id=$problem_id AND batch=$batch";
    if(!$conn->query($query)) {
        echo "There was a MySQL Query Error. Did the database crash?<hr />"."Error: " . $query . "<br>" . $conn->error;
    }

    $query = "INSERT INTO submissions (user_id, problem_id, batch, result, points) 
              VALUES ($user_id, $problem_id, $batch, '$result', $points)";

    if ($conn->query($query) === TRUE) {
        // Don't do anything special.
    } else {
        echo "There was a MySQL Query Error. Did the database crash? <hr />"."Error: " . $query . "<br>" . $conn->error;
    }

    // Add to the submission vault.
    $source_base64 = base64_encode($source);
    $query = "INSERT INTO submissions_vault (user_id, problem_id, batch, result, points, source, lang,  runtime)
              VALUES ($user_id, $problem_id, $batch, '$result', $points, '$source_base64', '$lang', 0)";
    if(!$conn->query($query)) {
        echo "There was a MySQL Query Error. Did the database crash?<hr />"."Error: " . $query . "<br>" . $conn->error;
    }

    $conn->close();
}

echo renderPageHead("View Score");
?>
<div class="card white hoverable">
<div class="card-content black-text">
<div class="row">
<?php
// Send the request to the backend grader server.
if(isset($_POST['lang'])) {

    // Get Problem info from SQL
    $problem = getProblemByID($_POST['id']);

    echo "<h4>".$problem['name']."</h4>";

    // Decode the input/output cases and send a request per testcase.
    $in_cases = json_decode($problem['in_cases']);
    $out_cases = json_decode($problem['out_cases']);

    $timelimit=$problem['timelimit'];

    //var_dump($in_cases);

    $length = count($in_cases);
    // Batch loop
    for($i = 0; $i < $length; $i++) {
        $answerAccepted = TRUE;
        $batch_in_cases = $in_cases[$i]->cases;
        $batch_out_cases = $out_cases[$i]->cases;
        $batch_length = count($batch_in_cases);

        $batchnum = $i + 1;
        echo str_pad("Batch $batchnum<hr />", 4096);
        // Testcase Loop
        for($x = 0; $x < $batch_length; $x++) {
            $in = $batch_in_cases[$x];
            $out  = $batch_out_cases[$x];
            //echo "Judge: ".$in." - ".$out."\n";
            $response = json_decode(judgeSolution($_POST['id'], $_SESSION['id'], $_POST['code'], $_POST['lang'], $in, $out, $timelimit));
            //var_dump($response);

            ?>
            <strong>Test Case <?php echo $x+1 ?>:
                <?php
                if($response->accepted == TRUE) {
                    // The browser/webserver/something needs a minimum of 4k in the buffer before it displays/flushes
                    // even though PHP is flushing the data.
                    echo str_pad("Accepted",4096);
                } else {
                    if($response->isCompileError) {
                        echo 'Compile Error: ';
                        echo $response->errorContent;
                        $answerAccepted = FALSE;
                    } else if($response->isCompileError) {
                        echo 'Time Limit Exceeded';
                        $answerAccepted = FALSE;
                    }else {
                        echo "Wrong Answer";
                        $answerAccepted = FALSE;
                    }
                    break;
                }
                ?>
            </strong><br />
            <?php
        }
        echo "<br />";
        // Write the answer to SQL
        if($answerAccepted) {
            addSubmissionToSQL("AC", $i, $in_cases[$i]->points, $_POST['code'], $_POST['lang']);
        }
    }
    echo "<strong>Execution Complete.</strong>";
    echo "<a class=\"waves-effect waves-light btn\" href=\"" . $config['page_root'] . "/Admin/CreateProblem.php\"><i class=\"material-icons left\">cloud</i>Back to problem.</a>";

    //var_dump( $response );

} else {
    echo 'Invalid request';
}

?>
</div>
</div>
</div>

<?php

echo renderPageFoot();

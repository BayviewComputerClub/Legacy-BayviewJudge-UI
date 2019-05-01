<?php
session_start();

// Please don't yell at me
// This causes things like echo to flush the PHP buffer, so for problems with
// lots of test cases the user can see the "Accepted" come in each test case.
ob_implicit_flush(true);

// Account for grader hanging
set_time_limit ( 10 );

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
        'input' => base64_encode($input),
        'output' => base64_encode($output),
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

function addSubmissionToSQL($result, $points) {
    // AC: Accepted, WA: Wrong Answer, TLE: Time Limit Exceeded, CE: Compile Error

    $config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");

    $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $user_id = $_SESSION['id'];
    $problem_id = $_POST['id'];

    // todo First delete any old submissions.

    $query = "DELETE FROM submissions WHERE user_id=$user_id AND problem_id=$problem_id";
    $conn->query($query);

    $query = "INSERT INTO submissions (user_id, problem_id, result, points) 
              VALUES ($user_id, $problem_id, '$result', $points)";

    if ($conn->query($query) === TRUE) {
        // Don't do anything special.
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }

    $conn->close();
}

echo renderPageHead("View Mark");
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

    $answerAccepted = TRUE;

    $length = count($in_cases);
    for($i = 0; $i < $length; $i++) {
        $in = $in_cases[$i];
        $out  = $out_cases[$i];
        //echo "Judge: ".$in." - ".$out."\n";
        $response = json_decode(judgeSolution($_POST['id'], $_SESSION['id'], $_POST['code'], $_POST['lang'], $in, $out, $timelimit));
        //var_dump($response);

        ?>
        <strong>Test Case <?php echo $i ?>:
        <?php
        if($response->accepted == TRUE) {
            // The browser/webserver/something needs a minimum of 4k in the buffer before it displays/flushes
            // even though PHP is flushing the data.
            echo str_pad("Accepted",4096);;
        } else {
            if($response->isCompileError) {
                echo 'Compile Error';
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
    // Write the answer to SQL
    if($answerAccepted) {
        addSubmissionToSQL("AC", $problem['points']);
    }
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
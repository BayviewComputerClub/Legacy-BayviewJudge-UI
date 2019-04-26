<?php
session_start();

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

function judgeSolution($problemID, $userID, $inputCode, $lang, $input, $output) {
    $config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");
    // Submission Request Object
    $data = array(
        'problemID' => $problemID,
        'userID' => $userID,
        'inputCode' => base64_encode($inputCode),
        'lang' => $lang,
        'input' => base64_encode($input),
        'output' => base64_encode($output)
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

    $length = count($in_cases);
    for($i = 0; $i < $length; $i++) {
        $in = $in_cases[$i];
        $out  = $out_cases[$i];
        //echo "Judge: ".$in." - ".$out."\n";
        $response = json_decode(judgeSolution($_POST['id'], $_SESSION['id'], $_POST['code'], $_POST['lang'], $in, $out));
        //var_dump($response);
        ?>
        <strong>Test Case 1:
        <?php
        if($response->accepted == TRUE) {
            echo "Accepted";
        } else {
            echo "Wrong Answer";
        }
        ?>
        </strong><br />
        <?php
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
<?php
session_start();
$config = include('../config.php');

if(!isset($_SESSION['username'])) {
    // User is not logged in!
    header("Location: ../index.php");
    die();
}

function callAPI($data, $endpoint, $callType) {
    $config = include('../config.php');
    $url = $config['judge_url'] . $endpoint;
    // Create the context for the request
    $context = stream_context_create(array(
        'http' => array(
            'method' => $callType,
            'header' => "Content-Type: application/json\r\n",
            'content' => json_encode($data),
            'ignore_errors' => true // Do not treat error 401 etc as real PHP error
        )
    ));
    // Send the request to the backend, and get the result.
    if(!$response = file_get_contents($url, FALSE, $context)) {
        // The response failed for whatever reason.
        return false;
    }
    // Check for errors
    if($response === FALSE){
        var_dump($response); // For debug only! Remove in production
        die('BayviewJudge has run into an unexpected error, please try again...');
    }
    return $response;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BayviewJudge Under Construction</title>
    <link rel="stylesheet" href="<?php $config['site_root'] ?>/css/bulma.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
</head>
<body>

<?php include '../parts/navbar.php'; ?>

<section class="section">

    <div class="columns">

        <!-- Vertical Nav -->
        <div class="column is-one-fifth has-background-grey">
            <?php include '../parts/navpanel.php'; ?>
        </div>

        <!-- Main Content -->
        <div class="column">

            <div class="container">
                <section class="hero is-medium is-primary is-bold">
                    <div class="hero-body">
                        <div class="container">
                            <h1 class="title">
                                Bayview Computer Club
                            </h1>
                            <h2 class="subtitle">
                                Judge Result
                            </h2>
                        </div>
                    </div>
                </section>
                <section class="hero is-info">
                    <div class="hero-body content has-text-black is-medium">
                        <?php

                            $userid = $_SESSION['id'];
                            $problemid = $_POST['problemid'];
                            $inputcode = $_POST['inputcode'];
                            $lang = $_POST['lang'];

                            // Get the test cases from the database.
                            $db = mysqli_connect($config['db_host'], $config['db_username'], $config['db_password'], $config['db_database']);
                            if (!$db) {
                                die("Connection failed: " . mysqli_connect_error());
                            }

                            $problem_query = "SELECT * FROM problems WHERE id=$problemid LIMIT 1";
                            $query_result = mysqli_query($db, $problem_query);
                            $result = mysqli_fetch_assoc($query_result);

                            $data = array(
                                'userID' => $userid,
                                'problemID' => $problemid,
                                'inputCode' => base64_encode($inputcode),
                                'lang' => $lang,
                                'sample_input' => $result['sample_input'],
                                'sample_output' => $result['sample_output'],
                                'input' => $result['input'],
                                'output' => $result['output'],
                                'timelimit' => $result['timelimit'],
                                'memlimit' => $result['memlimit']
                            );

                            $response = callAPI($data, '/v1/judge-submission', 'POST');
                            if(!$response) {
                                print 'There was an error with the judge server, please try again.';
                            } else {
                                $responseData = json_decode($response, TRUE);

                                //print $responseData['score'];
                                if($responseData['accepted']) {
                                    //print 'ok';
                                    for($i = 0; $i < $responseData['score'];$i++) {
                                        print "Test Case $i: Accepted! <br />";
                                    }
                                    print '<hr />';
                                    print '<p>Your submission passed all test cases!</p>';
                                    // Give user the points.

                                    $point_update_query = "UPDATE users SET points = points + 1 WHERE id = $userid
                                   ";
                                }else {
                                    for($i = 0; $i < $responseData['score'];$i++) {
                                        print "Test Case $i: Accepted! <br />";
                                    }
                                    print "Test Case $i: Not Accepted! <br />";
                                    print '<hr />';
                                    print 'Uh oh, Your submission was not accepted!';
                                }
                            }


                        ?>
                    </div>
                </section>

            </div>
        </div>

    </div>

    </div>

</section>
</body>
</html>


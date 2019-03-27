<?php
session_start();
$config = include('../config.php');

if(!isset($_SESSION['username'])) {
    // User is not logged in!
    header("Location: ../index.php");
    die();
}
// Is the user not an admin?
if(!$_SESSION['isadmin']) {
    header("Location: ../index.php");
    die();
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

    <script src='<?php $config['site_root'] ?>/tinymce/tinymce.min.js'></script>
    <script>
        tinymce.init({
            selector: '#problem_details'
        });
    </script>
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
                <?php

                if (isset($_POST['submit_problem'])) {
                    // Connect to MariaDB
                    $db = mysqli_connect($config['db_host'], $config['db_username'], $config['db_password'], $config['db_database']);

                    $errors = array();

                    // Form was submitted
                    $name = $_POST['name'];
                    $details = $_POST['details'];
                    $memlimit = $_POST['memlimit'];
                    $timelimit = $_POST['timelimit'];
                    $points = $_POST['points'];

                    $sample_input = base64_encode($_POST['sample_input']);
                    $sample_output = base64_encode($_POST['sample_output']);

                    $input = base64_encode($_POST['input']);
                    $output = base64_encode($_POST['output']);

                    $category = $_POST['category'];

                    // Deal with input errors
                    if (empty($name)) { array_push($errors, "Name is required"); }
                    if (empty($memlimit)) { array_push($errors, "Mem Limit is required"); }
                    if (empty($timelimit)) { array_push($errors, "Time Execution Limit is required"); }
                    if (empty($points)) { array_push($errors, "Points is required"); }
                    if (empty($details)) { array_push($errors, "Details is required"); }
                    if (empty($category)) { array_push($errors, "Category is required"); }

                    if (empty($sample_input)) { array_push($errors, "Sample Input is required"); }
                    if (empty($sample_output)) { array_push($errors, "Sample Output is required"); }

                    if (empty($input)) { array_push($errors, "Test Case Input is required"); }
                    if (empty($output)) { array_push($errors, "Test Case Output is required"); }


                    //If there are no errors, write the user to the database
                    if (count($errors) == 0) {

                        $query = "INSERT INTO problems (name, details, timelimit, memlimit, points, sample_input, sample_output, category, input, output) VALUES('$name', '$details', $timelimit, $memlimit, $points, '$sample_input', '$sample_output', '$category', '$input', '$output')";
                        mysqli_query($db, $query);


                        print "Yay! The problem was added! 🎉";
                        print '<br /><a class="button is-primary" href="index.php">Ok</a>';
                        print '<br />><b>Now go bug Seshan to add your testcases to the grading server.</b>';

                    } else {
                        print '<h1>There was an error adding the problem:</h1>';
                        foreach ($errors as $error) {
                            print "- $error<br />";
                        }
                    }

                } else {
                    ?>

                    <section class="hero is-medium is-primary is-bold">
                        <div class="hero-body">
                            <div class="container">
                                <h1 class="title">
                                    Admin - Create Problem
                                </h1>
                                <div class="columns">
                                    <div class="column is-three-quarters">
                                        <form action="createproblem.php" method="post">
                                            <div class="field">
                                                <label class="label">Name</label>
                                                <div class="control">
                                                    <input class="input" type="text" placeholder="e.g A plus B" name="name">
                                                </div>
                                            </div>


                                            <div class="field">
                                                <label class="label">Problem Details</label>
                                                <div class="control">
                                                    <textarea id="problem_details" name="details"></textarea>
                                                </div>
                                            </div>

                                            <hr />

                                            <div class="field">
                                                <label class="label">Memory Limit (MB)</label>
                                                <div class="control">
                                                    <input class="input" type="text" placeholder="1" name="memlimit">
                                                </div>
                                            </div>

                                            <div class="field">
                                                <label class="label">Time Limit (ms)</label>
                                                <div class="control">
                                                    <input class="input" type="text" placeholder="1000" name="timelimit">
                                                </div>
                                            </div>

                                            <div class="field">
                                                <label class="label">Points</label>
                                                <div class="control">
                                                    <input class="input" type="text" placeholder="2" name="points">
                                                </div>
                                            </div>

                                            <div class="field">
                                                <label class="label">Category</label>
                                                <div class="control">
                                                    <input class="input" type="text" placeholder="2" name="category">
                                                </div>
                                            </div>

                                            <div class="field">
                                                <label class="label">Sample Input (Displayed)</label>
                                                <div class="control">
                                                    <textarea class="textarea" type="text" placeholder="123" name="sample_input"></textarea>
                                                </div>
                                            </div>
                                            <div class="field">
                                                <label class="label">Sample Output (Displayed)</label>
                                                <div class="control">
                                                    <textarea class="textarea" type="text" placeholder="123" name="sample_output"></textarea>
                                                </div>
                                            </div>
                                            <hr />
                                            <h3 class="subtitle">Test Cases:</h3>
                                            <div class="field">
                                                <label class="label">Input</label>
                                                <div class="control">
                                                    <textarea class="textarea" type="text" placeholder="123" name="input"></textarea>
                                                </div>
                                            </div>
                                            <div class="field">
                                                <label class="label">Expected Output</label>
                                                <div class="control">
                                                    <textarea class="textarea" type="text" placeholder="123" name="output"></textarea>
                                                </div>
                                            </div>

                                            <hr />

                                            <div class="field">
                                                <div class="control">
                                                    <input class="button" type="submit" value="Add" name="submit_problem">
                                                </div>
                                            </div>

                                        </form>
                                    </div>

                                </div>


                            </div>
                        </div>
                    </section>


                <?php } // End of Login/Register POST if block ?>
            </div>
        </div>

    </div>

    </div>

</section>
</body>
</html>

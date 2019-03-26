<?php
session_start();
$config = include('../config.php');

if(!isset($_SESSION['username'])) {
    // User is not logged in!
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

    <script src='https://cloud.tinymce.com/5/tinymce.min.js'></script>
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


                    // Deal with input errors
                    if (empty($name)) { array_push($errors, "Name is required"); }
                    if (empty($memlimit)) { array_push($errors, "Mem Limit is required"); }
                    if (empty($timelimit)) { array_push($errors, "Time Execution Limit is required"); }
                    if (empty($points)) { array_push($errors, "Points is required"); }
                    if (empty($details)) { array_push($errors, "Details is required"); }


                    //If there are no errors, write the user to the database
                    if (count($errors) == 0) {

                        $query = "INSERT INTO problems (name, details, timelimit, memlimit, points) VALUES('$name', '$details', $timelimit, $memlimit, $points)";
                        mysqli_query($db, $query);


                        print "Yay! The problem was added! 🎉";
                        print '<br /><a class="button is-primary" href="createproblem.php">Ok</a>';
                        print '<br />><b>Now go bug Seshan to add your testcases to the grading server.</b>';

                    } else {
                        print '<h1>There was an error registering:</h1>';
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
                                    Admin - Edit Problem
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

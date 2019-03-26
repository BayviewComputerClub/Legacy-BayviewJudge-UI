<?php
session_start();
$config = include('../config.php');
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
                                View Problem
                            </h2>
                        </div>
                    </div>
                </section>
                <section class="hero is-info">
                    <div class="hero-body content has-text-black is-medium">

                        <?php

                        $requestedProblem = $_GET['id'];
                        //print $requestedProblem;

                        $db = mysqli_connect($config['db_host'], $config['db_username'], $config['db_password'], $config['db_database']);
                        if (!$db) {
                            die("Connection failed: " . mysqli_connect_error());
                        }

                        $problem_query = "SELECT * FROM problems WHERE id=$requestedProblem LIMIT 1";
                        $result = mysqli_query($db, $problem_query);
                        $problem = mysqli_fetch_assoc($result);

                        print '<h1 class="title">' . $problem['name'] . '</h1><hr />';

                        print '<p>' . $problem['details'] . '</p>';
                        print '<hr />';
                        print '<p>Memory Limit: ' . $problem['memlimit'] . 'MB</p>';
                        print '<p>Time Limit: ' . $problem['timelimit'] . 'ms </p>';
                        print '<hr />';
                        //print '<a href="" class="button">Submit Solution</a>';

                        ?>

                        <div class="column is-half">
                            <form action="submitproblem.php" method="post">
                                <div class="field">
                                    <label class="label">Language</label>
                                    <div class="control">
                                        <input class="input" type="text" placeholder="e.g c++" name="lang">
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="label">Code</label>
                                    <div class="control">
                                        <textarea class="textarea" type="textarea" placeholder="Paste Code here" name="inputcode"></textarea>
                                    </div>
                                </div>

                                <!-- Extra Params -->
                                <input type="hidden" name="problemid" value="<?php print $requestedProblem ?>" />

                                <hr />

                                <div class="field">
                                    <div class="control">
                                        <input class="button" type="submit" value="Submit" name="submit_code">
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </section>

            </div>
        </div>

    </div>

    </div>

</section>
</body>
</html>

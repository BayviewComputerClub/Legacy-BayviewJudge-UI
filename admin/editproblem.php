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
                <section class="hero is-medium is-primary is-bold">
                    <div class="hero-body">
                        <div class="container">
                            <h1 class="title">
                                Admin - Edit Problem
                            </h1>
                            <div class="columns">
                                <div class="column is-three-quarters">
                                    <table class="table">
                                        <tr>
                                            <th>Problem</th>
                                            <th>Points</th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <?php
                                            $db = mysqli_connect($config['db_host'], $config['db_username'], $config['db_password'], $config['db_database']);
                                            if (!$db) {
                                                die("Connection failed: " . mysqli_connect_error());
                                            }

                                            $problem_query = "SELECT id, name, details, timelimit, memlimit, points FROM problems";
                                            $result = mysqli_query($db, $problem_query);

                                            if (mysqli_num_rows($result) > 0) {
                                                while($row = mysqli_fetch_assoc($result)) {
                                                    echo "<tr><td> " . $row["name"] . "</td><td>" . $row["points"] ."</td><td><a href='./editproblem.php?id=" . $row['id'] . "' class='button'>Edit</a></td></tr>";
                                                }
                                            } else {
                                                echo "Error: No problems found (Yell at Seshan)";
                                            }
                                            ?>
                                        </tr>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Edit Block -->

                <?php

                    if(isset($_POST['edit_problem'])) {
                        // UPDATE `problems` SET `memlimit` = '101' WHERE `problems`.`id` = 4
                        $db = mysqli_connect($config['db_host'], $config['db_username'], $config['db_password'], $config['db_database']);
                        if (!$db) {
                            die("Connection failed: " . mysqli_connect_error());
                        }

                        $problemid = $_POST['problemid'];

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


                        // aaa.
                        $problem_query = "UPDATE problems SET name = '$name' WHERE id = $problemid ";
                        $result = mysqli_query($db, $problem_query);

                        $problem_query = "UPDATE problems SET details = '$details' WHERE id = $problemid ";
                        $result = mysqli_query($db, $problem_query);

                        $problem_query = "UPDATE problems SET memlimit = '$memlimit' WHERE id = $problemid ";
                        $result = mysqli_query($db, $problem_query);

                        $problem_query = "UPDATE problems SET timelimit = '$timelimit' WHERE id = $problemid ";
                        $result = mysqli_query($db, $problem_query);

                        $problem_query = "UPDATE problems SET points = '$points' WHERE id = $problemid ";
                        $result = mysqli_query($db, $problem_query);

                        $problem_query = "UPDATE problems SET sample_input = '$sample_input' WHERE id = $problemid ";
                        $result = mysqli_query($db, $problem_query);

                        $problem_query = "UPDATE problems SET sample_output = '$sample_output' WHERE id = $problemid ";
                        $result = mysqli_query($db, $problem_query);

                        $problem_query = "UPDATE problems SET input = '$input' WHERE id = $problemid ";
                        $result = mysqli_query($db, $problem_query);

                        $problem_query = "UPDATE problems SET output = '$output' WHERE id = $problemid ";
                        $result = mysqli_query($db, $problem_query);

                        $problem_query = "UPDATE problems SET category = '$category' WHERE id = $problemid ";
                        $result = mysqli_query($db, $problem_query);

                        var_dump($result);
                        print 'The problem has been updated!';

                    }

                    if(isset($_GET['id'])) {
                        $id = $_GET['id'];
                        $db = mysqli_connect($config['db_host'], $config['db_username'], $config['db_password'], $config['db_database']);
                        if (!$db) {
                            die("Connection failed: " . mysqli_connect_error());
                        }

                        $problem_query = "SELECT * FROM problems WHERE id=$id LIMIT 1";
                        $result = mysqli_query($db, $problem_query);
                        $problem = mysqli_fetch_assoc($result);

                ?>

                    <section class="hero is-medium is-primary is-bold"> <!-- In if block-->
                        <div class="hero-body">
                            <div class="container">
                                <h1 class="title">
                                    Edit:
                                </h1>
                                <div class="columns">
                                    <div class="column is-three-quarters">
                                        <form action="editproblem.php" method="post">

                                            <!-- Extra Params -->
                                            <input type="hidden" name="problemid" value="<?php print $id ?>" />

                                            <div class="field">
                                                <label class="label">Name</label>
                                                <div class="control">
                                                    <input class="input" type="text" placeholder="e.g A plus B" name="name" value="<?php print $problem['name']; ?>">
                                                </div>
                                            </div>


                                            <div class="field">
                                                <label class="label">Problem Details</label>
                                                <div class="control">
                                                    <textarea id="problem_details" name="details"><?php print $problem['details']; ?></textarea>
                                                </div>
                                            </div>

                                            <hr />

                                            <div class="field">
                                                <label class="label">Memory Limit (MB)</label>
                                                <div class="control">
                                                    <input class="input" type="text" placeholder="1" name="memlimit" value="<?php print $problem['memlimit']; ?>">
                                                </div>
                                            </div>

                                            <div class="field">
                                                <label class="label">Time Limit (ms)</label>
                                                <div class="control">
                                                    <input class="input" type="text" placeholder="1000" name="timelimit" value="<?php print $problem['timelimit']; ?>">
                                                </div>
                                            </div>

                                            <div class="field">
                                                <label class="label">Points</label>
                                                <div class="control">
                                                    <input class="input" type="text" placeholder="2" name="points" value="<?php print $problem['points']; ?>">
                                                </div>
                                            </div>

                                            <div class="field">
                                                <label class="label">Category</label>
                                                <div class="control">
                                                    <input class="input" type="text" placeholder="2" name="category" value="<?php print $problem['category']; ?>">
                                                </div>
                                            </div>

                                            <div class="field">
                                                <label class="label">Sample Input (Displayed)</label>
                                                <div class="control">
                                                    <textarea class="textarea" type="text" placeholder="123" name="sample_input"><?php print base64_decode($problem['sample_input']); ?></textarea>
                                                </div>
                                            </div>
                                            <div class="field">
                                                <label class="label">Sample Output (Displayed)</label>
                                                <div class="control">
                                                    <textarea class="textarea" type="text" placeholder="123" name="sample_output"><?php print base64_decode($problem['sample_output']); ?></textarea>
                                                </div>
                                            </div>
                                            <hr />
                                            <h3 class="subtitle">Test Cases:</h3>
                                            <div class="field">
                                                <label class="label">Input</label>
                                                <div class="control">
                                                    <textarea class="textarea" type="text" placeholder="123" name="input"><?php print base64_decode($problem['input']); ?></textarea>
                                                </div>
                                            </div>
                                            <div class="field">
                                                <label class="label">Expected Output</label>
                                                <div class="control">
                                                    <textarea class="textarea" type="text" placeholder="123" name="output"><?php print base64_decode($problem['output']); ?></textarea>
                                                </div>
                                            </div>

                                            <hr />

                                            <div class="field">
                                                <div class="control">
                                                    <input class="button" type="submit" value="Edit" name="edit_problem">
                                                </div>
                                            </div>

                                        </form>
                                    </div>

                                </div>


                            </div>
                        </div>
                    </section>

                <?php } //end section if ?>

            </div>
        </div>

    </div>

    </div>

</section>
</body>
</html>

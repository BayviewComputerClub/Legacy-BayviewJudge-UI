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
                                                    echo "<tr><td> " . $row["name"] . "</td><td>" . $row["points"] ."</td><td><a href='./viewproblem.php?id=" . $row['id'] . "' class='button'>Edit</a></td></tr>";
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
                    $name = "";
                    $details = "";
                    if(isset($_GET['id'])) {

                    }
                ?>

                <section class="hero is-medium is-primary is-bold">
                    <div class="hero-body">
                        <div class="container">
                            <h1 class="title">
                                Edit:
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

            </div>
        </div>

    </div>

    </div>

</section>
</body>
</html>

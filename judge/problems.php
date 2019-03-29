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

            <div class="container column is-four-fifths">
                <section class="hero is-medium is-primary is-bold">
                    <div class="hero-body">
                        <div class="container">
                            <h1 class="title">
                                Bayview Computer Club
                            </h1>
                            <h2 class="subtitle">
                                Judge Problems
                            </h2>
                        </div>
                    </div>
                </section>

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
                                echo "<tr><td> " . $row["name"] . "</td><td>" . $row["points"] ."</td><td><a href='./viewproblem.php?id=" . $row['id'] . "' class='button'>View</a></td></tr>";
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
</body>
</html>

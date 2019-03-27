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
    <title>BayviewJudge - Admin Home</title>
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
                                Admin Home - Be Careful!
                            </h2>
                        </div>
                    </div>
                </section>
                <section class="hero is-info">
                    <div class="hero-body content has-text-black is-medium">
                        <ul>
                            <li class="button"><a href="./createproblem.php">Create Problem</a></li>
                            <li class="button"><a href="./editproblem.php">Edit Problem</a></li>
                        </ul>
                    </div>
                </section>

            </div>
        </div>

    </div>

    </div>

</section>
</body>
</html>


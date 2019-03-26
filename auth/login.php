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

            <div class="container column is-11">
                <?php

                if (isset($_POST['login_user'])) {
                    // Connect to MariaDB
                    $db = mysqli_connect($config['db_host'], $config['db_username'], $config['db_password'], $config['db_database']);

                    $errors = array();

                    // Form was submitted
                    $username = mysqli_real_escape_string($db, $_POST['username']);
                    $password = $_POST['password'];


                    // Deal with input errors
                    if (empty($username)) { array_push($errors, "Username is required"); }
                    if (empty($password)) { array_push($errors, "Password is required"); }

                    // Verify the user exists, then verify the password hash.
                    $user_query = "SELECT * FROM users WHERE username='$username' LIMIT 1";
                    $result = mysqli_query($db, $user_query);
                    $user = mysqli_fetch_assoc($result);

                    if ($user) { // if user exists
                        if(password_verify($password, $user['password'])) { // verify the password against the hash
                            // OK, login
                            $query_id = "SELECT * FROM users WHERE username='$username' LIMIT 1";
                            $result_id = mysqli_fetch_assoc(mysqli_query($db, $query_id));
                            $id = $result_id['id'];

                            // Set the session, i.e login.
                            $_SESSION['username'] = $username;
                            $_SESSION['id'] = $id;

                            print "Yay! $username, You are now logged in 🎉 <br />";
                            print '<a class="button is-primary" href="../index.php">Home</a>';
                        } else {
                            array_push($errors, "Username/Password is incorrect!");
                        }
                    } else {
                        array_push($errors, "Username/Password is incorrect!");
                    }

                    //If there are errors, print them.
                    if (count($errors) > 0) {
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
                                    Login
                                </h1>
                                <div class="columns">
                                    <div class="column is-half">
                                        <form action="login.php" method="post">
                                            <div class="field">
                                                <label class="label">Username</label>
                                                <div class="control">
                                                    <input class="input" type="text" placeholder="e.g seshpenguin" name="username">
                                                </div>
                                            </div>

                                            <div class="field">
                                                <label class="label">Password</label>
                                                <div class="control">
                                                    <input class="input" type="password" placeholder="Create a strong password" name="password">
                                                </div>
                                            </div>

                                            <hr />

                                            <div class="field">
                                                <div class="control">
                                                    <input class="button" type="submit" value="Login" name="login_user">
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                    <div class="column is-4">
                                        <div class="card">
                                            <div class="card-content">
                                                <p class="title has-text-black">
                                                    BayviewJudge is under construction.
                                                </p>
                                                <p class="subtitle has-text-black">
                                                    Your experience is subject to bugs and issues, including resetting of user and problem data.
                                                </p>
                                                <p class="has-text-black">Please report bugs to <a href="https://github.com/BayviewComputerClub/BayviewJudge/issues">the git repo</a>.</a></p>
                                            </div>
                                            <footer class="card-footer">

                                            </footer>
                                        </div>
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

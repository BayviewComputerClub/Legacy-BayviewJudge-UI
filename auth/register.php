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

                if (isset($_POST['reg_user'])) {
                    // Connect to MariaDB
                    $db = mysqli_connect($config['db_host'], $config['db_username'], $config['db_password'], $config['db_database']);

                    $errors = array();

                    // Form was submitted
                    $username = mysqli_real_escape_string($db, $_POST['username']);
                    $email = mysqli_real_escape_string($db, $_POST['email']);
                    $password_1 = $_POST['password_1'];
                    $password_2 = $_POST['password_2'];

                    $school = mysqli_real_escape_string($db, $_POST['school']);
                    $full_name = mysqli_real_escape_string($db, $_POST['full_name']);

                    // Deal with input errors
                    if (empty($username)) { array_push($errors, "Username is required"); }
                    if (empty($email)) { array_push($errors, "Email is required"); }
                    if (empty($password_1)) { array_push($errors, "Password is required"); }
                    if ($password_1 != $password_2) {
                        array_push($errors, "The passwords do not match");
                    }

                    // Check if username is already taken
                    $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
                    $result = mysqli_query($db, $user_check_query);
                    $user = mysqli_fetch_assoc($result);

                    if ($user) { // if user exists
                        if ($user['username'] === $username) {
                            array_push($errors, "Username already exists");
                        }

                        if ($user['email'] === $email) {
                            array_push($errors, "Email already exists");
                        }
                    }

                    //If there are no errors, write the user to the database
                    if (count($errors) == 0) {
                        $password = password_hash($password_1, PASSWORD_DEFAULT); //encrypt the password before saving in the database



                        $query = "INSERT INTO users (username, password, email, points, full_name, school, profile_desc) VALUES('$username', '$password', '$email', 0, '$full_name', '$school', '')";
                        mysqli_query($db, $query);

                        // Query the users id.
                        $query_id = "SELECT * FROM users WHERE username='$username' LIMIT 1";
                        $result_id = mysqli_fetch_assoc(mysqli_query($db, $query_id));
                        $id = $result_id['id'];

                        $_SESSION['username'] = $username;
                        $_SESSION['id'] = $id;
                        print "Yay! $username#$id, You have been registered 🎉";
                        print '<a class="button is-primary" href="login.php">Login</a>';

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
                                    Register
                                </h1>
                                <div class="columns">
                                    <div class="column is-half">
                                        <form action="register.php" method="post">
                                            <div class="field">
                                                <label class="label">Username</label>
                                                <div class="control">
                                                    <input class="input" type="text" placeholder="e.g seshpenguin" name="username">
                                                </div>
                                            </div>

                                            <div class="field">
                                                <label class="label">Password</label>
                                                <div class="control">
                                                    <input class="input" type="password" placeholder="Create a strong password" name="password_1">
                                                </div>
                                            </div>
                                            <div class="field">
                                                <label class="label">Confirm Password</label>
                                                <div class="control">
                                                    <input class="input" type="password" placeholder="Retype your password" name="password_2">
                                                </div>
                                            </div>

                                            <div class="field">
                                                <label class="label">Email</label>
                                                <div class="control">
                                                    <input class="input" type="email" placeholder="e.g. seshan10@me.com" name="email">
                                                </div>
                                            </div>
                                            <hr />

                                            <div class="field">
                                                <label class="label">Full Name</label>
                                                <div class="control">
                                                    <input class="input" type="text" placeholder="e.g Seshan Ravikumar" name="full_name">
                                                </div>
                                            </div>

                                            <div class="field">
                                                <label class="label">School</label>
                                                <div class="control">
                                                    <input class="input" type="text" placeholder="e.g Bayview Secondary School" name="school">
                                                </div>
                                            </div>

                                            <hr />

                                            <div class="field">
                                                <div class="control">
                                                    <input class="button" type="submit" value="Register" name="reg_user">
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
                                                <p class="has-text-black">Please report bugs to <a href="https://github.com/BayviewComputerClub/BayviewJudge/issues">the git repo</a>.</p>
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

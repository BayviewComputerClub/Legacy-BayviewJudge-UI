<?php
session_start();
$config = include('./config.php');
?>
<!DOCTYPE html>
<html>
<head>

    <?php include './parts/material.php'; ?>
    <title>Home - BayviewJudge - Under Construction</title>

</head>

<body style="padding-left: 300px;">
    <!-- Navbar -->
    <?php include './parts/topnav.php'; ?>

    <!-- Sidenav -->
    <?php include './parts/sidenav.php'; ?>

    <!-- Body Content -->
    <div class="container">
        <br />
        <div class="card-panel white">
        <span class="black-text">
            <!-- Content -->
            <h1>Welcome to BayviewJudge!</h1>
            <hr />
            <p>This is a libre online judging platform for competitive programmers. It's a work in progress.</p>
        </span>
        </div>
        <!-- Blog Posts -->

    </div>

    <script>
        M.AutoInit();
    </script>
</body>
</html>
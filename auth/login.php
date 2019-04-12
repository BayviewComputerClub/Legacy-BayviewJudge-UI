<?php
session_start();
$config = include('../config.php');
?>
<!DOCTYPE html>
<html>
<head>

    <?php include '../parts/material.php'; ?>
    <title>Login - BayviewJudge - Under Construction</title>

</head>

<body style="padding-left: 300px;">
<!-- Navbar -->
<?php include '../parts/topnav.php'; ?>

<!-- Sidenav -->
<?php include '../parts/sidenav.php'; ?>

<!-- Body Content -->
<div class="container">
    <br/>
    <div class="card-panel white">
        <span class="black-text">
            <!-- Content -->
            <h1>Login</h1>
            <hr/>
              <div class="row">
                  <form class="col s12">
                      <div class="row">
                          <div class="input-field col s6">
                              <input id="first_name" type="text" class="validate">
                              <label for="first_name">Username</label>
                          </div>
                          <div class="input-field col s6">
                              <input id="last_name" type="text" class="validate">
                              <label for="last_name">Password</label>
                          </div>
                    </div>
                      <a class="waves-effect waves-light btn"><i class="material-icons left">cloud</i>Login</a>
                  </form>
              </div>
        </span>
    </div>
    <!-- Blog Posts -->

</div>

<script>
    M.AutoInit();
</script>
</body>
</html>
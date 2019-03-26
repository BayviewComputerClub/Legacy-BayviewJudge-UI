<nav class="navbar has-background-dark" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="../index.php">
            <h2 class="has-text-white">BayviewJudge</h2>
            <img src="<?php $config['site_root'] ?>/logo.png" />
        </a>
    </div>


    <div class="navbar-end">
        <div class="navbar-item">
            <div class="field is-grouped">
                <p class="control">
                    <?php
                        if(isset($_SESSION['username'])) {
                            ?>
                            <p class="has-text-white">Hey, <?php print $_SESSION['username'] ?>!</p>
                            <a class="button is-primary" href="<?php $config['site_root'] ?>/auth/logout.php">Logout</a>
                    <?php
                        } else {
                    ?>
                    <a class="button is-primary" href="<?php $config['site_root'] ?>/auth/login.php">Login</a>
                    <a class="button is-light" href="<?php $config['site_root'] ?>/auth/register.php" >Register</a>
                <?php } ?>
                </p>
            </div>
        </div>
    </div>

</nav>

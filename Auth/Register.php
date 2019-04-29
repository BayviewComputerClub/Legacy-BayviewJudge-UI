<?php
session_start();
$config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-head.php");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-foot.php");

if(isset($_SESSION['id'])) {
    header("Location: ".$config['page_root']);
    die();
}

echo renderPageHead("Register");
// Page Contents:
?>

<div class="card white hoverable">
    <div class="card-content black-text">
        <div class="row">
            <form class="col s12" action="<?php echo $config['page_root'] ?>/Controllers/RegisterUser.php" method="post">
                <div class="row">
                    <div class="input-field col s12">
                        <input placeholder="Placeholder" id="full_name" type="text" class="validate" name="full_name">
                        <label for="full_name">Full Name</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="username" type="text" class="validate" name="username">
                        <label for="username">Username</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="password" type="password" class="validate" name="password">
                        <label for="password">Password</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="email" type="email" class="validate" name="email">
                        <label for="email">Email</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="submit" type="submit" class="waves-effect waves-light btn" value="Register">
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

<?php
echo renderPageFoot();
?>

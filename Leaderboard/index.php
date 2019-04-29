<?php
session_start();
$config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-head.php");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-foot.php");

include($_SERVER['DOCUMENT_ROOT'] . "/Controllers/GetUser.php");

echo renderPageHead("Leaderboard");
// Page Contents:
?>

<div class="card white hoverable">
    <div class="card-content black-text">
        <div class="row">
            <h4>Leaderboard</h4>
            <table>
                <thead>
                <tr>
                    <th>Place</th>
                    <th>Name</th>
                    <th>Points</th>
                </tr>
                </thead>

                <tbody>
                <?php
                $users = getUsersList();
                $index  = 1;
                foreach($users as $user) {
                    ?>
                    <tr>
                        <td><?php echo $index ?></td>
                        <td><?php echo $user['username'] ?></td>
                        <td><?php echo computeScoreByID($user['id']) ?></td>
                    </tr>
                    <?php
                    $index++;
                }
                ?>


                </tbody>
            </table>
            <br />
            <p>Note: This leaderboard should not be considered final.</p>
        </div>
    </div>

</div>

<?php
echo renderPageFoot();
?>
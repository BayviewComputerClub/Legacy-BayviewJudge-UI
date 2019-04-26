<?php
session_start();
$config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-head.php");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-foot.php");

include($_SERVER['DOCUMENT_ROOT'] . "/Controllers/GetProblems.php");

echo renderPageHead("View Problems");
// Page Contents:
?>

    <div class="card white hoverable">
        <div class="card-content black-text">
            <div class="row">
                <table>
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Points</th>
                        <th>Submit Solution</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    $problems = getProblems();
                    foreach($problems as $problem) {
                    ?>
                        <tr>
                            <td><?php echo $problem['name'] ?></td>
                            <td><?php echo $problem['points'] ?></td>
                            <td><a href="#" class="btn waves-effect">View Problem</a></td>
                        </tr>
                    <?php
                    }
                    ?>


                    </tbody>
                </table>
            </div>
        </div>

    </div>

<?php
echo renderPageFoot();
?>
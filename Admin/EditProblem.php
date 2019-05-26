<?php
session_start();
$config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-head.php");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-foot.php");
if(!isset($_SESSION['id'])) {
    header("Location: ".$config['page_root']);
    die();
}

include($_SERVER['DOCUMENT_ROOT'] . "/Controllers/GetProblems.php");

echo renderPageHead("Edit Problems - Admin -");
?>


<div class="card white hoverable">
    <div class="card-content black-text">
        <div class="row">
            <h5>Select a problem to edit</h5>
        </div>
        <div class="row">
            <table>
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Points</th>
                    <th>Action</th>
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
                        <td><a href="EditProblem.php?id=<?php echo $problem['id'] ?>" class="btn waves-effect">Edit Problem</a></td>
                    </tr>
                    <?php
                }
                ?>


                </tbody>
            </table>
        </div>
        <?php
        if(isset($_GET['id'])) {
            // Get problem details.
            $problem = getProblemByID($_GET['id']);

            ?>
            <div class="row">
                <hr />
                <h5>Edit problem</h5>
                <form enctype="multipart/form-data" class="col s12" action="<?php echo $config['page_root'] ?>/Admin/Controllers/EditProblem.php" method="post">

                    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>" />

                    <div class="row">
                        <div class="input-field col s12">
                            <input id="name" type="text" class="validate" value="<?php echo $problem['name'] ?>" name="name">
                            <label for="name">Name</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <p>Problem Details PDF</p>
                            <input type="file" name="details" id="details">
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <input id="points" type="number" step="1" class="validate" value="<?php echo $problem['points'] ?>" name="points">
                            <label for="points">Points</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <input id="timelimit" type="number" step="1" class="validate" value="<?php echo $problem['timelimit'] ?>" name="timelimit">
                            <label for="timelimit">Time Limit (Seconds)</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <input id="memlimit" type="number" step="1" class="validate" value="<?php echo $problem['memlimit'] ?>" name="memlimit">
                            <label for="memlimit">Memory Limit (Megabytes)</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <textarea id="sample_input" class="materialize-textarea" name="sample_input"><?php echo $problem['sample_in'] ?></textarea>
                            <label for="sample_input">Sample Input</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <textarea id="sample_output" class="materialize-textarea" name="sample_output"><?php echo $problem['sample_out'] ?></textarea>
                            <label for="sample_output">Sample Output</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <input id="submit" type="submit" class="waves-effect waves-light btn" value="Edit">
                        </div>
                    </div>
                </form>
            </div>
            <?php
        }
        ?>
    </div>
</div>

<?php
echo renderPageFoot();
?>

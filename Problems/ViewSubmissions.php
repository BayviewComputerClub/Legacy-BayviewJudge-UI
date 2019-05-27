<?php
session_start();
$config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-head.php");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-foot.php");

include($_SERVER['DOCUMENT_ROOT'] . "/Controllers/GetProblems.php");
include($_SERVER['DOCUMENT_ROOT'] . "/Controllers/GetUser.php");
include($_SERVER['DOCUMENT_ROOT'] . "/Controllers/GetSubmissions.php");

echo renderPageHead("Submission Vault");

// Page Contents:
?>

<div class="card white hoverable">
    <div class="card-content black-text">
        <div class="row">
            <h4>Your Submissions</h4>

            <ul class="collapsible">
                <?php
                if(!isset($_SESSION['username'])) {
                    echo "You must be logged in to view the problems.";
                } else {
                    $submissions = getSubmissionsFromVaultByUserID($_SESSION['id']);
                    foreach($submissions as $submission) {
                        $problem = getProblems();
                        for($i = 0; $i < count($problem);$i++) {
                            //echo "ho"$problem[$i]->id;
                            if($problem[$i]['id'] == $submission['problem_id']) {
                                //echo "".mb_substr($problem[$i]['name'], 0, 2)."-".$submission['batch']." | ";
                                //var_dump($problem[$i])

                        ?>
                                <li>
                                    <div class="collapsible-header">
                                        <i class="material-icons">filter_drama</i>
                                        <?php echo $submission['submit_time'] ?> / Problem <?php echo $problem[$i]['name'] ?> - Batch <?php echo $submission['batch'] ?>
                                    </div>
                                    <div class="collapsible-body">
                                        <span>
                                            Result: <?php echo $submission['result'] ?> <br />
                                            Points: <?php echo $submission['points'] ?>
                                            <hr />
                                            Source:
                                            <blockquote>
                                                <pre> <!-- This is indented like this so the pre renders correctly -->
<?php echo base64_decode($submission['source']); ?>
                                                </pre>
                                            </blockquote>

                                        </span>
                                    </div>
                                </li>
                        <?php
                            }
                        }
                    }

                }
                ?>
            </ul>

        </div>
    </div>

</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.collapsible');
        var instances = M.Collapsible.init(elems, {});
    });
</script>
<?php
echo renderPageFoot();
?>

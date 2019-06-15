<?php
session_start();
$config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-head.php");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-foot.php");

include($_SERVER['DOCUMENT_ROOT'] . "/Controllers/GetProblems.php");

echo renderPageHead("View Problems | BayviewJudge");


// Page Contents:
?>

    <div class="card white hoverable">
        <div class="card-content black-text">
            <div class="row">
                <h4>Problems</h4>
                <a href="ViewSubmissions.php" class="btn waves-effect">Your Submissions</a>
                <hr />
                <table>
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Points</th>
                        <th>View Problem & Submit Solution</th>
                        <th>Problem Attempted</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    if(!isset($_SESSION['username'])) {
                        echo "You must be logged in to view the problems.";
                    } else {
                        $problems = getProblems();
                        foreach($problems as $problem) {

                            $problemID = $problem['id'];
                            $userID = $_SESSION['id'];

                            // Check if the user has an accepted solution.
                            $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
                            // Check connection
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            $query = "SELECT COUNT(*) AS total FROM submissions WHERE problem_id=$problemID AND user_id=$userID";
                            $result = $conn->query($query)->fetch_assoc();
                            //var_dump($result['total']);

                            $isDoneEmoji = "❌";

                            if($result['total'] > 0) {
                                $isDoneEmoji = "✅";
                            }
                            ?>
                            <tr>
                                <td><?php echo $problem['name'] ?></td>
                                <td><?php echo $problem['points'] ?></td>
                                <td><a href="SubmitProblem.php?id=<?php echo $problem['id'] ?>" class="btn waves-effect">View Problem</a></td>
                                <td><?php echo $isDoneEmoji ?></td>
                            </tr>
                            <?php
                        }

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

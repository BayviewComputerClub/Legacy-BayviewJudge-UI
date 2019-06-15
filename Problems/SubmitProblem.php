<?php
session_start();
$config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-head.php");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-foot.php");

include($_SERVER['DOCUMENT_ROOT'] . "/Controllers/GetProblems.php");

$problem = getProblemByID($_GET['id']);
//TODO account login check

echo renderPageHead("Submit Solution | BayviewJudge");
?>
<div class="card white hoverable">
    <div class="card-content black-text">
        <div class="row">

            <h3><?php echo $problem['name'] ?></h3>
            <hr />
            <p><iframe style="width: 100%; height: 90vh;" src="<?php echo urldecode($config['page_root'] . "/PDF/" .$problem['details']) ?>"></iframe></p>
            <p>Execution Time Limit: <?php echo $problem['timelimit'] ?>s</p>
            <p>Memory Limit: <?php echo $problem['memlimit'] ?>MB</p>
            <hr />
            <!-- <h4>Sample Input</h4>
            <p><?php echo $problem['sample_in'] ?></p>
            <h4>Sample Output</h4>
            <p><?php echo $problem['sample_out'] ?></p> -->

        </div>
        <div class="row">
            <form class="col s12" action="<?php echo $config['page_root'] ?>/Controllers/SubmitProblem.php" method="post">

                <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>" />

                <div class="row">
                    <div class="input-field col s12">
                        <select name="lang">
                            <option value="" disabled selected>Select a language</option>
                            <option value="c++">C++</option>
                            <option value="java">Java</option>
                            <option value="python">Python 3</option>
                        </select>
                        <label>Language</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <textarea id="code"  class="materialize-textarea" name="code"></textarea>

                        <label for="code">Paste Code Here</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="submit" type="submit" class="waves-effect waves-light btn" value="Submit for grading">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('select');
        var instances = M.FormSelect.init(elems);
    });
</script>
<?php
echo renderPageFoot();
?>
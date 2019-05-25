<?php
session_start();
$config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-head.php");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-foot.php");

// User must be logged in.
if(!isset($_SESSION['id'])) {
    header("Location: ".$config['page_root']);
    die();
}

echo renderPageHead("Create Problem - Admin");
?>

<script src='https://cloud.tinymce.com/5/tinymce.min.js'></script>
<script>
    tinymce.init({
        selector: '#details'
    });
</script>

<div class="card white hoverable">
    <div class="card-content black-text">
        <div class="row">
            <h4>Submit new problem</h4>
            <p>Note! The Input and Output cases must be in a JSON Array, with each index being a single test case (in and output).</p>
            <p>Sample In and Out are just text blocks, rendered to the user (don't forget to add them as your first test case)</p>
        </div>
        <div class="row">
            <form class="col s12" action="<?php echo $config['page_root'] ?>/Admin/Controllers/CreateProblem.php" method="post">
                <div class="row">
                    <div class="input-field col s12">
                        <input id="name" type="text" class="validate" name="name">
                        <label for="name">Name</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <p>Problem Details</p>
                        <textarea id="details" name="details"></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <input id="points" type="number" step="1" class="validate" name="points">
                        <label for="points">Points</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <input id="timelimit" type="number" step="1" class="validate" name="timelimit">
                        <label for="timelimit">Time Lime (Seconds)</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <input id="memlimit" type="number" step="1" class="validate" name="memlimit">
                        <label for="memlimit">Memory Lime (Megabytes)</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <textarea id="sample_input" class="materialize-textarea" name="sample_input"></textarea>
                        <label for="sample_input">Sample Input</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <textarea id="sample_output" class="materialize-textarea" name="sample_output"></textarea>
                        <label for="sample_output">Sample Output</label>
                    </div>
                </div>
                <!--
                <div class="row">
                    <div class="input-field col s12">
                        <textarea id="input" class="materialize-textarea" name="input"></textarea>
                        <label for="input">Input JSON</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <textarea id="output" class="materialize-textarea" name="output"></textarea>
                        <label for="output">Output JSON</label>
                    </div>
                </div>
                -->

                <div class="row">
                    <div class="input-field col s12">
                        <input id="submit" type="submit" class="waves-effect waves-light btn" value="Add Problem">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
echo renderPageFoot();
?>
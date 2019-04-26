<?php
$config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-head.php");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-foot.php");

echo renderPageHead("Create Problem - Admin");
?>

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
                        <textarea id="details"  class="materialize-textarea" name="details"></textarea>
                        <label for="details">Problem Details</label>
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
                        <input id="sample_input" type="number" step="1" class="validate" name="sample_input">
                        <label for="sample_input">Sample Input</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <input id="sample_output" type="number" step="1" class="validate" name="sample_output">
                        <label for="sample_output">Sample Output</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <input id="input" type="number" step="1" class="validate" name="input">
                        <label for="input">Input JSON</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <input id="sample_output" type="number" step="1" class="validate" name="soutput">
                        <label for="sample_output">Output JSON</label>
                    </div>
                </div>


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
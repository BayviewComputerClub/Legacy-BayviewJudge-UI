<?php

$config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-head.php");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-foot.php");

echo renderPageHead("About");
?>
<div class="card white hoverable">
    <div class="card-content black-text">
        <div class="row">
            <h4>About BayviewJudge</h4>
            <p>BayviewJudge is a online competitive programming judging platform. That is, users solve various mathematics and logical problems using code, and
            then upload their solution to get it automatically judged for correctness of their solution.
            </p>
            <p>Created by Seshan</p>
            <hr />
            <p>The judge is very strict, output must match the output spec exactly.</p>
        </div>
    </div>
</div>
<?php
echo renderPageFoot();
?>

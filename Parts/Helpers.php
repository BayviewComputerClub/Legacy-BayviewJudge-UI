<?php

function printCard($message) {
    return <<<HTML
<div class="card white hoverable">
    <div class="card-content black-text">
        <div class="row">
            $message
        </div>
    </div>
</div>
HTML;
}
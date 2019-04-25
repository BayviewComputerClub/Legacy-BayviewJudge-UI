<?php
function renderPageFoot() {
    $pageRoot = $config['page_root'];
    return <<<HTML
        
        </div>
        <!--JavaScript at end of body for optimized loading-->
        <script type="text/javascript" src="$pageRoot/Assets/materialize/js/materialize.min.js"></script>
    </body>
</html>
HTML;

}
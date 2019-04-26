<?php
function renderPageFoot() {
    $config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");
    $pageRoot = $config['page_root'];
    return <<<HTML
        
        </div>
        <!--JavaScript at end of body for optimized loading-->
        <script type="text/javascript" src="$pageRoot/Assets/materialize/js/materialize.min.js"></script>
    </body>
</html>
HTML;

}
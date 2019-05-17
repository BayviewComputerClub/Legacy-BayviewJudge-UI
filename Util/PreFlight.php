<?php
// The preflight checks function should run before each page load (through .htaccess on Apache)
// It does sanity checks for example, and can check if a user has been banned.

// Silly little thing, count how many requests the
file_put_contents("/var/www/html/Util/count.txt",@file_get_contents("/var/www/html/Util/count.txt")+1);
?>
<!-- Preflight checks have run -->

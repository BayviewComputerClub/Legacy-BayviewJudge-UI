<?php
/*
    BayviewJudge UI
    Copyright (C) 2019  Seshan Ravikumar

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as
    published by the Free Software Foundation, either version 3 of the
    License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.

 */
session_start();
$config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-head.php");
include($_SERVER['DOCUMENT_ROOT'] . "/Parts/page-foot.php");
include($_SERVER['DOCUMENT_ROOT'] . "/Util/SiteMetadata.php");

echo renderPageHead("Home");
// Page Contents:
?>

    <div class="card white hoverable">
        <div class="card-content black-text">
            <span class="card-title"></span>
            <?php echo getMetaValue("home_text"); ?>
        </div>
        <div class="card-action">
            <a href="<?php echo $config['page_root'] ?>/Problems/ViewProblems.php">View Problems</a>
            <a href="<?php echo $config['page_root'] ?>/Leaderboard">Leaderboard</a>
            <a href="<?php echo $config['page_root'] ?>/Auth/Register.php">Register</a>
        </div>
    </div>

<?php
echo renderPageFoot();
?>

# BayviewJudge UI

Historically this was the "full stack" web frontend for BayviewJudge, however this is now being transitioned into a RESTful backend, and the actual UI will be a React webapp.

Don't forget to have a [grader server][1] too!

In order to run the UI, you must have Apache, MySQL/MariaDB, and PHP 7.x installed. Place these files in the html root directory. There is a supplied SQL file you can import into the database. Make to set the correct values in "Config/config.ini".

In production the Judge UI runs on Ubuntu 18.04 with Apache, PHP 7.2, and MySQL. It has been tested to work on both Mac OS X and Windows, and will probably run wherever there is 
a reasonably modern version of PHP (>5.6 or something like that).

## Installation Instructions

### Ubuntu GNU/Linux
1. With a fresh Ubuntu Server installation, setup a LAMP stack as per [this guide][4].
2. Optionally [install PHPMyAdmin][5] to make database setup easier.
3. Clone this repository somewhere (like home), and then copy the files to /var/www/html
4. Create a new database on MySQL and import the bayviewjudge.sql file.
5. Edit the Config/config.ini file with your MySQL and Webserver information.

There is a `deploy_gnulinux.sh` script which will automatically git pull, copy the files to /var/www/html, and copy a config.ini from from ~/config.ini

Don't forget to `AllowOverride All` in the Apache config.

### Windows
1. Download [XAMPP][2] and run the installer. Keep the default installation directories. You only need the Apache, MySql and PHP elements.
2. Download [this repository][3] and unzip it into `C:\xampp\htdocs`.
3. Launch the XAMPP Control Panel with administrator privileges (I just toggle the run as admin property in the start menu shortcut so it always runs as admin by default. *Note: You obviously need admin privileges for this.*)
4. On the lefthand side under `modules` in the Control Panel, you should see `Service`. Click the :x: and wait for it to change to a :heavy_check_mark:.
5. Go to :wrench:`Config` at the top right of the Control Panel, `User Defined Files` at the bottom left of the popu dialog and then `MySQL`. Under the `Config` box, put `\htdocs\bayviewjudge.sql`. :heavy_check_mark:`Save` twice. If you've done something wrong, :x:`Abort`.
6. Now under `Actions` in the main XAMPP Control Panel, click `Start` for both `Apache` and `MySQL`.
7. Go to `localhost/` in your browser to see the site. There will be a bunch of errors.
8. Go to `localhost/phpmyadmin/`. Create a new database called `bayviewjudge`, with charset `UTF-8 (general)`.
9. Import `bayviewjudge.sql` (from `C:\xampp\htdocs`) into the newly created database. Refresh [localhost/] to see the site.

## Creating Testcases

The judge accepts input and output cases in the form of a JSON array of test batch objects.

Consider the following input cases for a A+B problem:
```json
[ { "cases": ["1 2", "4 5"], "points": 5 }, { "cases": ["7 5"], "points": 5 } ]
```
This example has 2 batches, with 2 test cases in the first batch and one in the second.

The corresponding output cases would look as such:
```json
[ { "cases": ["3", "9"] }, { "cases": ["12"] } ]
```

**Before adding a problem to the judge, make sure your input and output cases are valid JSON!**


[1]: https://github.com/BayviewComputerClub/BayviewJudge-Grader
[2]: https://www.apachefriends.org/download.html
[3]: https://github.com/BayviewComputerClub/BayviewJudge-UI/archive/master.zip
[4]: https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-ubuntu-18-04
[5]: https://www.digitalocean.com/community/tutorials/how-to-install-and-secure-phpmyadmin-on-ubuntu-18-04

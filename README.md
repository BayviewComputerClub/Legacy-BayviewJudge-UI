# BayviewJudge UI

Web UI for the Bayview Computer Club's Online Judge

Don't forget to have a grader server too! [https://github.com/BayviewComputerClub/BayviewJudge-Grader](https://github.com/BayviewComputerClub/BayviewJudge-Grader)

In order to run the UI, you must have Apache, MySQL/MariaDB, and PHP 7.x installed. Place these files in the html root directory. There is a supplied SQL file you can import into the database. Make to set the correct values in "Config/config.ini".

The judge is only tested to work in production on Ubuntu GNU/Linux. Some features will not work correctly on other operating systems without modification.

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

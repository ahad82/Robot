ROBOT TOY
========
## Running the application
You need php5.6 or greater to run the application.
Verify your php installation version using
php --version

The application should run using default test data provided in `practice\input.json`
Run the following command


`php Robot/index.php`

## Stack information
Developed on PHP 5.6

## input.json
Input file to execute the list of commands.

The file is composed of array of command sets. Each command set represents one example given in the requirement document.

## Unit tests
I have used a local installation of unit test. To run unit tests please  use

`phpunit tests/RobotToyTest.php`
<?php
require_once('AutoLoader.php');
use Library\RobotToy;
use Library\CommandInterpreter;
/**
     N
* W--|--E
 *   S
Example Input and Output
a)----------------
PLACE 0,0,NORTH
MOVE
REPORT
Output: 0,1,NORTH
b)----------------
PLACE 0,0,NORTH
LEFT
REPORT
Output: 0,0,WEST
c)----------------
PLACE 1,2,EAST
MOVE
MOVE
LEFT
MOVE
REPORT
Output: 3,3,NORTH
 **/
$input = file_get_contents('input.json');
$commandList = json_decode($input, true);
$commandInterpreter = new CommandInterpreter();
foreach($commandList as $command) {
    $robot = new RobotToy();
    $commandInterpreter->execute($robot, $command['set'], $command['setid']);
}
$report = $commandInterpreter->getStatusReport();
displayReport($report);

/**
 * Will display only failed commands due to dimension issues etc
 * and final report
 * @param $report
 */

function displayReport($report, $detailed_flag = false) {
    foreach ($report as $command_set_id => $commands) {
        echo "************** START *******************\n";
        echo "COMMAND SET ID : $command_set_id \n";

        if ($detailed_flag) { // Will include results of all commands, include success and failure reasons
            foreach ($commands as $command => $result) {
                echo "Result of command execution [[$command]] \n";
                print_r($result);

            }
        } else { // report only
            echo "Result of command execution [[report]] \n";
            print_r($commands['report']);
        }

        echo "************** END *******************\n";
    }
}

<?php
chdir(__DIR__);
require_once('AutoLoader.php');
use Library\RobotToy;
use Library\CommandInterpreter;

$input = file_get_contents('./input.json');
$commandList = json_decode($input, true);
$commandInterpreter = new CommandInterpreter();
foreach($commandList as $command) {
    $robot = new RobotToy();
    $commandInterpreter->execute($robot, $command['set'], $command['setid']);
}
$report = $commandInterpreter->getStatusReport();
displayReport($report);

/**
 * @param $report
 * @param $detailed_flag
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

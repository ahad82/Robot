<?php
require_once('AutoLoader.php');
use Library\RobotToy;
use Library\CommandInterpreter;
/**
   N
W--|--E
 * S
 The application is a simulation of a toy robot moving on a square table top, of dimensions 5
units x 5 units. There are no other obstructions on the table surface. The robot is free to
roam around the surface of the table, but must be prevented from falling to destruction.
Any movement that would result in the robot falling from the table must be prevented,
however further valid movement commands must still be allowed.

PLACE X,Y,F
MOVE
LEFT
RIGHT
REPORT
• PLACE will put the toy robot on the table in position X,Y and facing NORTH, SOUTH,
EAST or WEST.
• The origin (0,0) can be considered to be the SOUTH WEST most corner. It is required
that the first command to the robot is a PLACE command, after that, any sequence
of commands may be issued, in any order, including another PLACE command.
• The application should discard all commands in the sequence until a valid PLACE
command has been executed.
• MOVE will move the toy robot one unit forward in the direction it is currently facing.
• LEFT and RIGHT will rotate the robot 90 degrees in the specified direction without
changing the position of the robot.
• REPORT will announce the X,Y and F of the robot. This can be in any form, but
standard output is sufficient. A robot that is not on the table can choose to ignore
the MOVE, LEFT, RIGHT and REPORT commands.
• Input can be from a file, or from standard input, as the developer chooses.

Constraints
The toy robot must not fall off the table during movement. This also includes the initial
placement of the toy robot. Any move that would cause the robot to fall must be ignored.
 *
 *
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

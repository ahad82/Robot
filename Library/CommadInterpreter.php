<?php
namespace Library;

class CommandInterpreter {

    const COMMANDS_WHITELIST = ['place', 'move', 'left', 'right', 'report'];
    protected $statusReport = [];
    public function __construct()
    {
    }

    public function execute(RobotToy $robot, $commandList) {
        foreach ($commandList as $commandObj) {
            $command = $commandObj['command'];
            $args = "";
            if (isset($commandObj['args'])) {
                $args = implode(',' , $commandObj['args']);
            }

            if (!$output = $robot->$command($args)) {
                $this->statusReport[$command] = $robot->getErrorMsg();
            } else {
                $this->statusReport[$command] = $output;
            }
        }
    }

    public function getStatusReport()
    {
        return $this->statusReport;
    }
}


?>


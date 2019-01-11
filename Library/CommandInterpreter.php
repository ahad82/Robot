<?php
namespace Library;

/**
 * Class CommandInterpreter
 * @package Library
 */
class CommandInterpreter
{

    /**
     * @var array
     */
    protected $statusReport = [];

    /**
     * @param $command
     * @return bool
     */
    protected function isValid($command)
    {
        return in_array($command, static::COMMANDS_WHITELIST);
    }

    /**
     * @param RobotToy $robot
     * @param $commandList
     */
    public function execute(RobotToy $robot, $commandList, $set_id)
    {
        foreach ($commandList as $commandObj) {
            $command = $commandObj['command'];

            // check if action exists for this object
            if (!method_exists($robot, $command)) {
                $this->statusReport[$command] = 'Action does not exist';
                continue;
            }

            $args = isset($commandObj['args']) ? $commandObj['args'] : [];

            if (!$output = call_user_func_array(array($robot, $command), $args)) {
                $this->statusReport[$set_id][$command]['failed'][] = $robot->getErrorMsg();
                $this->runLog('Error: ' . $robot->getErrorMsg());
            } else {
                $this->statusReport[$set_id][$command]['success'][] = $output;
            }
        }
    }

    /**
     * @return array
     */
    public function getStatusReport()
    {
        return $this->statusReport;
    }

    /**
     * @param $str
     */
    public function runLog($str)
    {
        error_log($str);
    }
}

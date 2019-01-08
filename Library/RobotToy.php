<?php
namespace Library;

class RobotToy
{
    const X_AXIS_WHITELIST = [0, 1, 2, 3, 4, 5];
    const Y_AXIS_WHITELIST = [0, 1, 2, 3, 4, 5];
    const DIR_WHITELIST = ["north", "east", "west", "south"];

    protected $x_axis = 0;
    protected $y_axis = 0;
    protected $dir = "north";
    protected $errorMsg = "";

    /**
     * RobotToy constructor.
     */
    public function __construct()
    {
        //initialize with defaults;
        $this->place();
    }

    /**
     * @param int $x
     * @param int $y
     * @param string $dir
     * @return bool
     */
    public function place($x = 0, $y = 0, $dir = "north")
    {
        if ($this->validatePlaceDetails($x, $y, $dir)) {
            $this->x_axis = (int)$x;
            $this->y_axis = (int)$y;
            $this->dir = strtolower($dir);
        } else {
            return false;
        }

    }

    protected function validatePlaceDetails($x, $y, $dir)
    {
        $x = (int)$x;
        $y = (int)$y;
        $dir = strtolower($dir);

        $result = true;
        if (!in_array($x, static::X_AXIS_WHITELIST)) {
            $this->errorMsg = 'Invalid x axis provided';
            $result = false;
        }
        if (!in_array($y, static::Y_AXIS_WHITELIST)) {
            $this->errorMsg = 'Invalid y axis provided';
            $result = false;
        }
        if (!in_array($dir, static::X_AXIS_WHITELIST)) {
            $this->errorMsg = 'Invalid x axis provided';
            $result = false;
        }

        return $result;
    }

    /**
     * @param $axis
     * @param $boundry
     * @param bool $increment
     * @throws \Exception
     */
    protected function canMove($axis, $boundry, $increment = true)
    {
        if (!in_array($axis, $boundry)) {
            throw new \Exception('Invalid dimensions');
        }

        if ($axis == end($boundry) && $increment) {
            throw new \Exception('Can not move another unit, out of bound');
        }

        if ($axis == $boundry[0] && !$increment) {
            throw new \Exception('Can not move another unit, out of bound');
        }
    }


    /**
     * @return bool
     */
    public function move()
    {
        try {
            switch ($this->dir) {
                case 'north':
                    $this->canMove($this->y_axis, static::Y_AXIS_WHITELIST);
                    $this->y_axis++;
                    break;
                case 'east':
                    $this->canMove($this->x_axis, static::X_AXIS_WHITELIST);
                    $this->x_axis++;
                    break;
                case 'south':
                    $this->canMove($this->y_axis, static::Y_AXIS_WHITELIST, false);
                    $this->y_axis--;
                    break;
                case 'west':
                    $this->canMove($this->x_axis, static::X_AXIS_WHITELIST, false);
                    $this->x_axis--;
                    break;
                default:
                    throw new \Exception('Direction not set yet, trying calling place first');
            }

        } catch (\Exception $e) {
            $this->errorMsg = $e->getMessage();
            return false;
        }

        return true;
    }

    /**
     * @param $dir
     * @return mixed|string
     */
    public function left()
    {
        $dir_list = ['north', 'west', 'south', 'east'];
        $this->dir = $this->turn($this->dir, $dir_list);
        return $this->dir;
    }

    /**
     * @param $dir
     * @return mixed|string
     */
    public function right()
    {
        $dir_list = ['north', 'east', 'south', 'west'];
        $this->dir = $this->turn($this->dir, $dir_list);
        return $this->dir;
    }

    /**
     * @param $dir
     * @param $dir_list
     * @return mixed
     */
    public function turn($dir, $dir_list)
    {
        $index = array_search($dir, $dir_list);
        if ($index !== false) {
            $count = count($dir_list);
            //last element must be 'east'
            if ($index + 1 == $count) {
                $ret = $dir_list[0];
            } else {
                $ret = $dir_list[$index + 1];
            }
            return $ret;
        } else {
            $this->errorMsg = 'Invalid direction';
            return false;
        }

    }

    /**
     * @return array
     */
    public function report()
    {
        return [
            'x_axis' => $this->x_axis,
            'y_axis' => $this->y_axis,
            'direction' => $this->dir,
        ];
    }

    /**
     * @return string
     */
    public function getErrorMsg() {
        return $this->errorMsg;
    }
}
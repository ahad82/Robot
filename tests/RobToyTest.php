<?php
use PHPUnit\Framework\TestCase;

/**
 * Class Test
 */
class RobotToyTest extends TestCase
{
    public function setup()
    {
        require_once("./Library/RobotToy.php");
        $this->rt = new Library\RobotToy();
    }

    /**
     *
     */
    public function testLeftFullRound()
    {
        $this->assertEquals($this->rt->left(), 'west');
        $this->assertEquals($this->rt->left(), 'south');
        $this->assertEquals($this->rt->left(), 'east');
        $this->assertEquals($this->rt->left(), 'north');
        $this->assertEquals($this->rt->left(), 'west');
        $this->assertEquals($this->rt->left(), 'south');
    }

    /**
     *
     */
    public function testRightFullRound()
    {
        $this->assertEquals($this->rt->right(), 'east');
        $this->assertEquals($this->rt->right(), 'south');
        $this->assertEquals($this->rt->right(), 'west');
        $this->assertEquals($this->rt->right(), 'north');
        $this->assertEquals($this->rt->right(), 'east');
        $this->assertEquals($this->rt->right(), 'south');
    }

    /**
     *
     */
    public function testOutofBoundPlaceData()
    {
        $this->assertEquals($this->rt->place(0, 6, 'north'), false);
        $this->assertEquals($this->rt->place(0, -6, 'north'), false);
        $this->assertEquals($this->rt->place(10, 5, 'west'), false);
        $this->assertEquals($this->rt->place(0, 5, 'norths'), false);
        $this->assertEquals($this->rt->place(0, 5.5, 'norths'), false);
    }

    /**
     *
     */
    public function testMoveEastOneUnitFromStart()
    {
        $this->rt->place(0, 0, 'east');
        $this->rt->move();
        $actual = $this->rt->report();
        $expected = [
            'x_axis' => 1,
            'y_axis' => 0,
            'direction' => 'east'
        ];
        $this->assertEquals($actual, $expected);
    }

    /**
     *
     */
    public function testMoveEastOutOfBound()
    {
        $this->rt->place(5, 0, 'east');
        $this->assertEquals($this->rt->move(),false);
        $this->assertEquals($this->rt->move(),false);
        $this->rt->move();
        $actual = $this->rt->report();
        $expected = [
            'x_axis' => 5,
            'y_axis' => 0,
            'direction' => 'east'
        ];
        $this->assertEquals($actual, $expected);
    }

    /**
     *
     */
    public function testMoveNorthOutOfBound()
    {
        $this->rt->place(5, 4, 'north');
        $this->assertEquals($this->rt->move(),true);
        $this->assertEquals($this->rt->move(),false);
        $this->rt->move();
        $actual = $this->rt->report();
        $expected = [
            'x_axis' => 5,
            'y_axis' => 5,
            'direction' => 'north'
        ];
        $this->assertEquals($actual, $expected);
    }

}

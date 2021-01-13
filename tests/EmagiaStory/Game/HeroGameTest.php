<?php

namespace Tests\EmagiaStory\Game;

use PHPUnit\Framework\TestCase;

class HeroGameTest extends TestCase
{
    protected $hero;

    protected $wildBeast;

    protected function setUp()
    {
        $hero = $this->getMockBuilder('EmagiaStory\Characters\Hero')->getMock();
        $hero->setHealth(20)
             ->setStrength(30)
             ->setDefence(40)
             ->setSpeed(50)
             ->setLuck(60);
        $this->hero = $hero;

        $wildBeast = $this->getMockBuilder('EmagiaStory\Characters\WildBeast')->getMock();
        $wildBeast->setHealth(25)
                  ->setStrength(23)
                  ->setDefence(45)
                  ->setSpeed(65)
                  ->setLuck(35)
        ;
        $this->wildBeast = $wildBeast;
    }

    public function testPlayersAliveTrue()
    {
        $hero = $this->hero;
        self::assertTrue($hero->getHealth() > 0, 'Hero is still alive');

        $wildBeast = $this->wildBeast;
        self::assertTrue($wildBeast->getHeath() > 0, 'WildBeast is still alive');
    }
}

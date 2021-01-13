<?php

namespace Tests\EmagiaStory\Characters;

use PHPUnit\Framework\TestCase;

class CharactersTest extends TestCase
{
    protected $character;

    protected function setUp()
    {
        $character = $this->getMockBuilder('EmagiaStory\Characters\CharactersAbstract')
                          ->getMockForAbstractClass();

        $character->setHealth(70);
        $character->setStrength(80);
        $character->setDefence(75);
        $character->setSpeed(85);
        $character->setLuck(40);

        $this->character = $character;
    }

    public function testGetSetHealth()
    {
        $character = $this->character;
        self::assertEquals(70, $character->getHealth());
        $character->setHealth(20);
        self::assertEquals(20, $character->getHealth());
    }

    public function testGetSetStrength()
    {
        $character = $this->character;
        self::assertEquals(80, $character->getStrength());
        $character->setStrength(30);
        self::assertEquals(30, $character->getStrength());
    }

    public function testGetSetDefence()
    {
        $character = $this->character;
        self::assertEquals(75, $character->getDefence());
        $character->setDefence(35);
        self::assertEquals(35, $character->getDefence());
    }

    public function testGetSetSpeed()
    {
        $character = $this->character;
        self::assertEquals(85, $character->getSpeed());
        $character->setSpeed(55);
        self::assertEquals(55, $character->getSpeed());
    }

    public function testGetSetLuck()
    {
        $character = $this->character;
        self::assertEquals(40, $character->getLuck());
        $character->setLuck(55);
        self::assertEquals(55, $character->getLuck());
    }
}

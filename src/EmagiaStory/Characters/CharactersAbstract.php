<?php

declare(strict_types=1);

namespace EmagiaStory\Characters;

abstract class CharactersAbstract
{
    protected $playerName;

    protected $health;

    protected $strength;

    protected $defence;

    protected $speed;

    protected $luck;

    public function __construct() {}

    public function getPlayerName(): string
    {
        return $this->playerName;
    }

    public function setPlayerName(string $playerName): CharactersAbstract
    {
        $this->playerName = $playerName;

        return $this;
    }

    public function getHealth(): int
    {
        return $this->health;
    }

    public function setHealth(int $health): CharactersAbstract
    {
        $this->health = $health;

        return $this;
    }

    public function getStrength(): int
    {
        return $this->strength;
    }

    public function setStrength(int $strength): CharactersAbstract
    {
        $this->strength = $strength;

        return $this;
    }

    public function getDefence(): int
    {
        return $this->defence;
    }

    public function setDefence(int $defence): CharactersAbstract
    {
        $this->defence = $defence;

        return $this;
    }

    public function getSpeed(): int
    {
        return $this->speed;
    }

    public function setSpeed(int $speed): CharactersAbstract
    {
        $this->speed = $speed;

        return $this;
    }

    public function getLuck(): int
    {
        return $this->luck;
    }

    public function setLuck(int $luck): CharactersAbstract
    {
        $this->luck = $luck;

        return $this;
    }
}
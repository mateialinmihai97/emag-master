<?php
declare(strict_types=1);

namespace EmagiaStory\Skills;

abstract class SkillsAbstract
{
    const RAPID_STRIKE_CLASS = 'RapidStrike';
    const MAGIC_SHIELD_CLASS = 'MagicShield';

    protected $chance;

    protected $type;

    protected $useSkill;

    public function __construct(string $type, int $chance)
    {
        $this->type = $type;
        $this->chance = $chance;
    }

    public function getChance(): int
    {
        return $this->chance;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getUseSkill(): bool
    {
        return $this->useSkill;
    }

    public function useSkill(): SkillsAbstract
    {
        $rand = mt_rand(0, 100);
        $useSkill = $rand <= $this->getChance();
        $this->useSkill = $useSkill;

        return $this;
    }
}
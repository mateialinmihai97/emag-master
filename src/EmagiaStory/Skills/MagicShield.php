<?php
declare(strict_types=1);

namespace EmagiaStory\Skills;

class MagicShield extends SkillsAbstract implements SkillsInterface
{
    public function __construct(string $type, int $chance)
    {
        parent::__construct($type, $chance);
    }

    public function getSpecialDamage(int $damage): int
    {
        return $damage / 2;
    }
}
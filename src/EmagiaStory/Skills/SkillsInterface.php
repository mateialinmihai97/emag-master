<?php

declare(strict_types=1);

namespace EmagiaStory\Skills;

interface SkillsInterface
{
    public function getSpecialDamage(int $damage): int;
}
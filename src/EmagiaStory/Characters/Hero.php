<?php

declare(strict_types=1);

namespace EmagiaStory\Characters;

use EmagiaStory\Skills\SkillsAbstract;

class Hero extends CharactersAbstract
{
    protected $skills = [];

    protected $skillsTypes = [SkillsAbstract::RAPID_STRIKE_CLASS, SkillsAbstract::MAGIC_SHIELD_CLASS];

    public function getSkillsTypes(): array
    {
        return $this->skillsTypes;
    }

    public function getSkills(): array
    {
        return $this->skills;
    }

    public function addSkill(SkillsAbstract $skill): Hero
    {
        foreach ($this->skillsTypes as $skillType) {
            if (!$this->skillIsSet($skill, $skillType) && $skillType == $skill->getType()) {
                $this->skills[$skillType] = $skill;
            }
        }

        return $this;
    }

    private function skillIsSet(SkillsAbstract $skill, string $skillType)
    {
        if (isset($this->skills[$skillType]) && $this->skills[$skillType] instanceof $skill) {
            return true;
        }

        return false;
    }
}
<?php

namespace Tests\EmagiaStory\Skills;

use PHPUnit\Framework\TestCase;

class SkillsTest extends TestCase
{
    public function testUseSkillTrue() {
        $skill = $this
            ->getMockBuilder('EmagiaStory\Skills\SkillsAbstract')
            ->setConstructorArgs(['skill', 100])
            ->getMockForAbstractClass()
        ;

        $skill->useSkill();
        $result = $skill->getUseSkill();

        $this->assertEquals(true, $result);
    }

    public function testUseSkillFalse() {
        $skill = $this
            ->getMockBuilder('EmagiaStory\Skills\SkillsAbstract')
            ->setConstructorArgs(['skill', 0])
            ->getMockForAbstractClass();
        $skill->useSkill();
        $result = $skill->getUseSkill();

        $this->assertEquals(false, $result);
    }
}

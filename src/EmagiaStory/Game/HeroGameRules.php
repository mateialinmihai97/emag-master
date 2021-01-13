<?php

namespace EmagiaStory\Game;

class HeroGameRules
{
    /* Hero default settings */
    const HERO_NAME = 'ORDERUS';
    const HERO_ABILITIES = [
        'MIN_HEALTH'    => 70,
        'MAX_HEALTH'    => 100,
        'MIN_STRENGTH'  => 70,
        'MAX_STRENGTH'  => 80,
        'MIN_DEFENCE'   => 45,
        'MAX_DEFENCE'   => 55,
        'MIN_SPEED'     => 40,
        'MAX_SPEED'     => 50,
        'MIN_LUCK'      => 10,
        'MAX_LUCK'      => 30,
    ];
    const HERO_SKILLS = [
        'RAPID_STRIKE'  => 10,
        'MAGIC_SHIELD'  => 20,
    ];

    /* Wild beast default settings */
    const WILD_BEASTS_NAMES = [
        'LUNA FANG',
        'MAD HUNTER',
        'FARREL',
        'MUMMY CLAWS'
    ];
    const WILD_BEAST_ABILITIES = [
        'MIN_HEALTH'    => 60,
        'MAX_HEALTH'    => 90,
        'MIN_STRENGTH'  => 60,
        'MAX_STRENGTH'  => 90,
        'MIN_DEFENCE'   => 40,
        'MAX_DEFENCE'   => 60,
        'MIN_SPEED'     => 40,
        'MAX_SPEED'     => 60,
        'MIN_LUCK'      => 25,
        'MAX_LUCK'      => 40,
    ];
}
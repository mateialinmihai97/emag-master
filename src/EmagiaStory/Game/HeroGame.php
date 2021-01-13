<?php
declare(strict_types=1);

namespace EmagiaStory\Game;

use EmagiaStory\Characters\CharactersAbstract;
use EmagiaStory\Characters\Hero;
use EmagiaStory\Characters\WildBeast;
use EmagiaStory\Skills\MagicShield;
use EmagiaStory\Skills\RapidStrike;
use EmagiaStory\Skills\SkillsAbstract;

class HeroGame
{
    const MAX_BATTLE_ROUNDS = 20;
    const ATTACKER_HERO = 'hero';
    const ATTACKER_WILD_BEATS = 'wildBeast';

    protected $hero;

    protected $wildBeast;

    protected $winner;

    protected $attacker;

    protected $startAbilities = [];

    public function startBattle()
    {
        try {
            $this->initGame();
            $roundsPlayed = 1;

            while ($this->getPlayersAreAlive() && $roundsPlayed <= self::MAX_BATTLE_ROUNDS) {

                $this->log('Abilities after attack nr. : ' . $roundsPlayed . PHP_EOL);
                $this->log(PHP_EOL);

                switch ($this->attacker) {
                    case self::ATTACKER_HERO:
                        $this->heroAttacks();
                        $this->attacker = self::ATTACKER_WILD_BEATS;
                        break;
                    case self::ATTACKER_WILD_BEATS:
                        $this->wildBeastAttacks();
                        $this->attacker = self::ATTACKER_HERO;
                        break;
                }

                $this->addHeroSpecialSkills();
                $roundsPlayed++;
            }

            $this->setWinner();
            $this->log('Winner is: ' . $this->winner->getPlayerName());

        } catch (\Exception $e) {
            $this->log($e->getMessage());
        }
    }

    public function initGame()
    {
        $this->createHero()
            ->createWildBeast()
            ->firstAttacker()
        ;

        $this->logInitGame();

    }

    private function createHero(): HeroGame
    {
        $this->hero = new Hero();
        $this->getStartAbilities(HeroGameRules::HERO_ABILITIES);

        $this->hero->setPlayerName(HeroGameRules::HERO_NAME);
        foreach ($this->startAbilities as $key => $value) {
            $methodName = 'set' . ucfirst($key);
            $this->hero->{$methodName}($value);
        }

        $this->addHeroSpecialSkills();

        return $this;
    }

    private function createWildBeast(): HeroGame
    {
        $this->wildBeast = new WildBeast();
        $this->getStartAbilities(HeroGameRules::WILD_BEAST_ABILITIES);

        $randKey = array_rand(HeroGameRules::WILD_BEASTS_NAMES, 1);
        $this->wildBeast->setPlayerName(HeroGameRules::WILD_BEASTS_NAMES[$randKey]);
        foreach ($this->startAbilities as $key => $value) {
            $methodName = 'set' . ucfirst($key);
            $this->wildBeast->{$methodName}($value);
        }

        return $this;
    }

    private function addHeroSpecialSkills(): HeroGame
    {
        $rapidStrike = new RapidStrike(SkillsAbstract::RAPID_STRIKE_CLASS, HeroGameRules::HERO_SKILLS['RAPID_STRIKE']);
        $magicShield = new MagicShield(SkillsAbstract::MAGIC_SHIELD_CLASS, HeroGameRules::HERO_SKILLS['MAGIC_SHIELD']);

        $this->hero->addSkill($rapidStrike->useSkill())
            ->addSkill($magicShield->useSkill())
        ;

        return $this;
    }

    private function firstAttacker()
    {
        if ($this->hero->getSpeed() > $this->wildBeast->getSpeed()) {
            $this->attacker = self::ATTACKER_HERO;
        } elseif ($this->hero->getSpeed() < $this->wildBeast->getSpeed()) {
            $this->attacker = self::ATTACKER_WILD_BEATS;
        } elseif ($this->hero->getLuck() > $this->wildBeast->getLuck()) {
            $this->attacker = self::ATTACKER_HERO;
        } elseif ($this->hero->getLuck() < $this->wildBeast->getLuck()) {
            $this->attacker = self::ATTACKER_WILD_BEATS;
        } else {
            $this->initGame();
        }
    }

    private function getFirstAttackerName($type): string
    {
        if ($type == self::ATTACKER_HERO) {
            return $this->hero->getPlayerName();
        } else {
            return $this->wildBeast->getPlayerName();
        }
    }

    private function getStartAbilities(array $abilities)
    {
        $uniqueAbilities = $this->getUniqueAbilities($abilities);

        foreach ($uniqueAbilities as $ability) {
            $this->startAbilities[strtolower($ability)] = $this->getRandom(
                $abilities['MIN_'. $ability],
                $abilities['MAX_'. $ability],
                $ability);
        }
    }

    private function getUniqueAbilities(array $abilities): array
    {
        $result = [];
        foreach ($abilities as $key => $value) {
            if (($pos = strpos($key, "_")) !== FALSE) {
                $result[] = substr($key, $pos + 1);
            } else {
                throw new \Exception('One ability constant does not have the right key format');
            }
        }

        return array_unique($result);
    }

    private function getPlayersAreAlive()
    {
        if($this->hero->getHealth() > 0 && $this->wildBeast->getHealth() > 0) {
            return true;
        }

        return false;
    }

    private function getRandom(int $min = 10, int $max = 0, string $ability): int
    {
       if ($min >= $max) {
           throw new \Exception('The values provided for: ' . $ability . 'are not correct!') ;
       }

       return mt_rand($min, $max);
    }

    private function heroAttacks()
    {
        $rapidStrike = $this->getHeroSkill(SkillsAbstract::RAPID_STRIKE_CLASS);
        $damage = $this->getDamage($this->hero, $this->wildBeast);

        if ($rapidStrike->getUseSkill()) {
            $damage = $rapidStrike->getSpecialDamage($damage);
        }

        $wildBeastHealth = $this->wildBeast->getHealth() - $damage;
        $this->wildBeast->setHealth($wildBeastHealth);

        $this->logUsedSkill($rapidStrike);
        $this->logPlayersSkills();
    }

    public function wildBeastAttacks()
    {
        $magicShield = $this->getHeroSkill(SkillsAbstract::MAGIC_SHIELD_CLASS);
        $damage = $this->getDamage($this->wildBeast, $this->hero);

        if ($magicShield->getUseSkill()) {
            $damage = $magicShield->getSpecialDamage($damage);
        }

        $heroHealth = $this->hero->getHealth() - $damage;
        $this->hero->setHealth($heroHealth);

        $this->logUsedSkill($magicShield);
        $this->logPlayersSkills();
    }

    private function getDamage(CharactersAbstract $attacker, CharactersAbstract $defender): int
    {
        return $attacker->getStrength() - $defender->getDefence();
    }

    private function getHeroSkill(string $skill): SkillsAbstract
    {
        $skillTypes = $this->hero->getSkillsTypes();

        if (empty($skill)) {
            throw new \Exception('Please provide a skill type');
        }

        if (!in_array($skill, $skillTypes)) {
            throw new \Exception('Wrong skill type provided!');
        }

        $skills = $this->hero->getSkills();

        return $skills[$skill];
    }

    private function setWinner(): HeroGame
    {
        if ($this->hero->getHealth() > $this->wildBeast->getHealth()) {
            $this->winner = $this->hero;
        } else {
            $this->winner = $this->wildBeast;
        }

        return $this;
    }

    private function log(string $message)
    {
        var_dump($message);
    }

    private function logPlayersSkills()
    {
        $this->log($this->hero->getPlayerName() . ' abilities:' . PHP_EOL . PHP_EOL);
        $this->logUniqueAbilitiesValues($this->hero);
        $this->log(PHP_EOL);

        $this->log($this->wildBeast->getPlayerName() . ' abilities:' . PHP_EOL . PHP_EOL);
        $this->logUniqueAbilitiesValues($this->wildBeast);
        $this->log(PHP_EOL);
        $this->log('******************' . PHP_EOL . PHP_EOL);
    }

    private function logUniqueAbilitiesValues($player)
    {
        $uniqueAbilities = $this->getUniqueAbilities(HeroGameRules::HERO_ABILITIES);

        foreach ($uniqueAbilities as $ability) {
            $methodName = 'get' . ucfirst(strtolower($ability));
            $this->log($ability . " : " . $player->{$methodName}() . PHP_EOL);
        }
    }

    private function logInitGame()
    {
        $firstAttackerName = $this->getFirstAttackerName($this->attacker);
        $this->log(PHP_EOL);
        $this->log('First attacker will be ' . $this->attacker . ' : ' . $firstAttackerName);
        $this->log(PHP_EOL);
        $this->log(PHP_EOL);
        $this->logPlayersSkills();
    }

    private function logUsedSkill(SkillsAbstract $skill)
    {
        if ($skill->getUseSkill()) {
            $this->log('Hero uses ' . $skill->getType() . '!!!');
        } else {
            $this->log('Hero uses no skill!');
        }
        $this->log(PHP_EOL);
    }
}
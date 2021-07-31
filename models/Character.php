<?php

namespace app\models;

use app\core\Application;
use app\core\db\DbModel;
use app\core\Functions;

#[Character]
class Character extends DbModel
{
    public function __construct(
        public string $name = '',
        public string $class = '',
        public int $level = 1,
        public string $background = '',
        public string $race = '',
        public string $alignment = '',
        public int $experiencePoints = 0,
        public array $attributes = array(
            'strength' => 0,
            'dexterity' => 0,
            'constitution' => 0,
            'intelligence' => 0,
            'wisdom' => 0,
            'charisma' => 0
        ),
        public int $inspiration = 0,
        public int $proficiency = 0,
        public array $savingThrows = array(
            'strength' => 0,
            'dexterity' => 0,
            'constitution' => 0,
            'intelligence' => 0,
            'wisdom' => 0,
            'charisma' => 0
        ),
        public array $skills = array(
            'acrobatics' => 0,
            'animalHandling' => 0,
            'arcana' => 0,
            'athletics' => 0,
            'deception' => 0,
            'history' => 0,
            'insight' => 0,
            'intimidation' => 0,
            'investigation' => 0,
            'medicine' => 0,
            'nature' => 0,
            'perception' => 0,
            'performance' => 0,
            'persuasion' => 0,
            'religion' => 0,
            'sleightOfHand' => 0,
            'stealth' => 0,
            'survival' => 0
        ),
        public array $proficienciesAndLanguages = array(),
        public  array $money = array(
            'CP' => 0,
            'SP' => 0,
            'EP' => 0,
            'GP' => 0,
            'PP' => 0
        ),
        public int $armor = 0,
        public int $initiative = 0,
        public int $speed = 0,
        public int $currentHitPoints = 0,
        public int $temporaryHitPoints = 0,
        public int $numberOfDice = 0,
        public int $sidesOfDice = 0,
        public array $deathSaves = array(
            'successes' => 3,
            'failures' => 3
        ),
        public array $attacks = array(),
        public array $equipment = array(),
        public string $personalityTraits = '',
        public string $ideals = '',
        public string $bonds = '',
        public string $flaws = '',
        public array $features = array()
    ) {
        $this->hitDice = new Dice($numberOfDice, $sidesOfDice);
        $this->file = date('Ymd-gi');
    }

    public int $id = 0;
    public string $user = 'retroDUD';
    public int $isPublic = 1;
    public string $file = '';

    protected Dice $hitDice;

    private bool $named = false;

    public function __toString(): string
    {
        return '\nName: ' . $this->name .
            '\nClass: ' . $this->class .
            '\nLevel: ' . $this->level .
            '\nRace: ' . $this->race .
            '\nBackground: ' . $this->background .
            '\nAlignment: ' . $this->alignment .
            '\nExperience points: ' . $this->experiencePoints .
            '\n\nAttributes:\n' . Functions::arrayToString($this->attributes) .
            '\n\nHas inspiration: ' . $this->inspiration .
            '\nProficiency: ' . $this->proficiency .
            '\n\nSaving throws:\n' . Functions::arrayToString($this->savingThrows) .
            '\n\nSkills:\n' . Functions::arrayToString($this->skills) .
            '\n\nProficiencies and Languages:\n' . Functions::arrayToString($this->proficienciesAndLanguages) .
            '\n\nMoney:\n' . Functions::arrayToString($this->money) .
            '\nArmor: ' . $this->armor .
            '\nInitiative: ' . $this->initiative .
            '\nSpeed: ' . $this->speed .
            '\nCurrent hit points: ' . $this->currentHitPoints .
            '\nTemporary hit points: ' . $this->temporaryHitPoints .
            '\nHit dice: ' . $this->hitDice .
            '\n\nDeath saves:\n' . Functions::arrayToString($this->deathSaves) .
            '\n\nPersonality traits: ' . $this->personalityTraits .
            '\nIdeals: ' . $this->ideals .
            '\nBonds: ' . $this->bonds .
            '\nFlaws: ' . $this->flaws .
            '\n\nAttacks:\n' . Functions::arrayToString($this->attacks, true) .
            '\n\nEquipment:\n' . Functions::arrayToString($this->equipment, true) .
            '\n\nFeatures:\n' . Functions::arrayToString($this->features) .
            '\n';
    }

    public static function tableName(): string
    {
        return 'Characters';
    }

    public function attributes(): array
    {
        return [
            'name',
            'class',
            'level',
            'background',
            'race',
            'alignment',
            'experiencePoints',
            'attributes',
            'inspiration',
            'proficiency',
            'savingThrows',
            'skills',
            'proficienciesAndLanguages',
            'money',
            'armor',
            'initiative',
            'speed',
            'currentHitPoints',
            'temporaryHitPoints',
            'numberOfDice',
            'sidesOfDice',
            'deathSaves',
            'attacks',
            'equipment',
            'personalityTraits',
            'ideals',
            'bonds',
            'flaws',
            'features',
            'user',
            'isPublic',
            'id',
            'file'
        ];
    }

    public function labels(): array
    {
        return [
            'name' => 'Name: ',
            'class' => 'Class: ',
            'level' => 'Level: ',
            'background' => 'Background: ',
            'race' => 'Race: ',
            'alignment' => 'Alignment: ',
            'experiencePoints' => 'Experience points: ',
            'attributes' => 'Attributes',
            'attributes/strength' => 'Strength: ',
            'attributes/dexterity' => 'Dexterity: ',
            'attributes/constitution' => 'Constitution: ',
            'attributes/intelligence' => 'Intelligence: ',
            'attributes/wisdom' => 'Wisdom: ',
            'attributes/charisma' => 'Charisma: ',
            'inspiration' => 'Inspiration: ',
            'proficiency' => 'Proficiency',
            'savingThrows' => 'Saving throws',
            'savingThrows/strength' => 'Strength: ',
            'savingThrows/dexterity' => 'Dexterity: ',
            'savingThrows/constitution' => 'Constitution: ',
            'savingThrows/intelligence' => 'Intelligence: ',
            'savingThrows/wisdom' => 'Wisdom: ',
            'savingThrows/charisma' => 'Charisma: ',
            'skills' => 'Skills',
            'skills/acrobatics' => 'Acrobatics: ',
            'skills/animalHandling' => 'Animal Handling',
            'skills/arcana' => 'Arcana: ',
            'skills/athletics' => 'Athletics: ',
            'skills/deception' => 'Deception: ',
            'skills/history' => 'History: ',
            'skills/insight' => 'Insight: ',
            'skills/intimidation' => 'Intimidation: ',
            'skills/investigation' => 'Investigation: ',
            'skills/medicine' => 'Medicine: ',
            'skills/nature' => 'Nature: ',
            'skills/perception' => 'Perception: ',
            'skills/performance' => 'Performance: ',
            'skills/persuasion' => 'Persuasion: ',
            'skills/religion' => 'Religion: ',
            'skills/sleightOfHand' => 'Sleight of Hand: ',
            'skills/stealth' => 'Stealth: ',
            'skills/survival' => 'Survival: ',
            'proficiencies' => 'Proficiencies: ',
            'languages' => 'Languages: ',
            'money' => 'Money',
            'money/CP' => 'CP: ',
            'money/SP' => 'SP: ',
            'money/EP' => 'EP: ',
            'money/GP' => 'GP: ',
            'money/PP' => 'PP: ',
            'armor' => 'Armor: ',
            'initiative' => 'Initiative: ',
            'speed' => 'Speed: ',
            'currentHitPoints' => 'Current Hit Points',
            'temporaryHitPoints' => 'Temporary Hit Points',
            'numberOfDice' => 'Dice: ',
            'sidesOfDice' => 'd',
            'deathSaves' => 'Death saves',
            'successes' => 'Successes: ',
            'failures' => 'Failures: ',
            'attacks' => 'Attacks: ',
            'equipment' => 'Equipment: ',
            'personalityTraits' => 'Personality Traits: ',
            'ideals' => 'Ideals: ',
            'bonds' => 'Bonds: ',
            'flaws' => 'Flaws: ',
            'features' => 'Features: ',
            'user' => 'User: ',
            'upload' => '',
            'saveFile' => '',
            'downloadPdf' => '',
            'isPublic' => ''
        ];
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function rules(): array
    {
        return [
            'name' => [self::RULE_REQUIRED],
            'class' => [self::RULE_REQUIRED],
            'race' => [self::RULE_REQUIRED],
            'attributes/strength' => [self::RULE_NUMBER],
            'attributes/dexterity' => [self::RULE_NUMBER],
            'attributes/constitution' => [self::RULE_NUMBER],
            'attributes/intelligence' => [self::RULE_NUMBER],
            'attributes/wisdom' => [self::RULE_NUMBER],
            'attributes/charisma' => [self::RULE_NUMBER],
            'savingThrows/strength' => [self::RULE_NUMBER],
            'savingThrows/dexterity' => [self::RULE_NUMBER],
            'savingThrows/constitution' => [self::RULE_NUMBER],
            'savingThrows/intelligence' => [self::RULE_NUMBER],
            'savingThrows/wisdom' => [self::RULE_NUMBER],
            'savingThrows/charisma' => [self::RULE_NUMBER],
            'proficiency' => [self::RULE_NUMBER],
            'skills/acrobatics' => [self::RULE_NUMBER],
            'skills/animalHandling' => [self::RULE_NUMBER],
            'skills/arcana' => [self::RULE_NUMBER],
            'skills/athletics' => [self::RULE_NUMBER],
            'skills/deception' => [self::RULE_NUMBER],
            'skills/history' => [self::RULE_NUMBER],
            'skills/insight' => [self::RULE_NUMBER],
            'skills/intimidation' => [self::RULE_NUMBER],
            'skills/investigation' => [self::RULE_NUMBER],
            'skills/medicine' => [self::RULE_NUMBER],
            'skills/nature' => [self::RULE_NUMBER],
            'skills/perception' => [self::RULE_NUMBER],
            'skills/performance' => [self::RULE_NUMBER],
            'skills/persuasion' => [self::RULE_NUMBER],
            'skills/religion' => [self::RULE_NUMBER],
            'skills/sleightOfHand' => [self::RULE_NUMBER],
            'skills/stealth' => [self::RULE_NUMBER],
            'skills/survival' => [self::RULE_NUMBER],
            'money/CP' => [self::RULE_NUMBER],
            'money/SP' => [self::RULE_NUMBER],
            'money/EP' => [self::RULE_NUMBER],
            'money/GP' => [self::RULE_NUMBER],
            'money/PP' => [self::RULE_NUMBER],
            'armor' => [self::RULE_NUMBER],
            'initiative' => [self::RULE_NUMBER],
            'speed' => [self::RULE_NUMBER],
            'numberOfDice' => [self::RULE_NUMBER],
            'sidesOfDice' => [self::RULE_NUMBER]
        ];
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setClass(string $class): void
    {
        $this->class = $class;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function setLevel(int $level): void
    {
        $this->level = $level;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function setBackground(string $background): void
    {
        $this->background = $background;
    }

    public function getBackground(): string
    {
        return $this->background;
    }

    public function setRace(string $race): void
    {
        $this->race = $race;
    }

    public function getRace(): string
    {
        return $this->race;
    }

    public function setAlignment(string $alignment): void
    {
        $this->alignment = $alignment;
    }

    public function getAlignment(): string
    {
        return $this->alignment;
    }

    public function setExperiencePoints(int $experiencePoints): void
    {
        $this->experiencePoints = $experiencePoints;
    }

    public function getExperiencePoints(): int
    {
        return $this->experiencePoints;
    }

    public function setAttributes(array $attributes): void
    {
        $this->attributes = $attributes;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function setInspiration(bool $inspiration): void
    {
        $this->inspiration = $inspiration;
    }

    public function getInspiration(): bool
    {
        return $this->inspiration;
    }

    public function setProficiency(int $proficiency): void
    {
        $this->proficiency = $proficiency;
    }

    public function getProficiency(): int
    {
        return $this->proficiency;
    }

    public function setSavingThrows(array $savingThrows): void
    {
        $this->savingThrows = $savingThrows;
    }

    public function getSavingThrows(): array
    {
        return $this->savingThrows;
    }

    public function setSkills(array $skills): void
    {
        $this->skills = $skills;
    }

    public function getSkills(): array
    {
        return $this->skills;
    }

    public function setProficienciesAndLanguages(array $proficienciesAndLanguages): void
    {
        $this->proficienciesAndLanguages = $proficienciesAndLanguages;
    }

    public function getProficienciesAndLanguages(bool $html = FALSE): array
    {
        return $this->proficienciesAndLanguages;
    }

    public function setMoney(array $money): void
    {
        $this->money = $money;
    }

    public function getMoney(bool $html = FALSE): array
    {
        return $this->money;
    }

    public function setArmor(int $armor): void
    {
        $this->armor = $armor;
    }

    public function getArmor(): int
    {
        return $this->armor;
    }

    public function setInitiative(int $initiative): void
    {
        $this->initiative = $initiative;
    }

    public function getInitiative(): int
    {
        return $this->initiative;
    }

    public function setSpeed(int $speed): void
    {
        $this->speed = $speed;
    }

    public function getSpeed(): int
    {
        return $this->speed;
    }

    public function setCurrentHitPoints(int $currentHitPoints): void
    {
        $this->currentHitPoints = $currentHitPoints;
    }

    public function getCurrentHitPoints(): int
    {
        return $this->currentHitPoints;
    }

    public function setTemporaryHitPoints(int $temporaryHitPoints): void
    {
        $this->temporaryHitPoints = $temporaryHitPoints;
    }

    public function getTemporaryHitPoints(): int
    {
        return $this->temporaryHitPoints;
    }

    public function setHitDice(Dice $hitDice): void
    {
        $this->hitDice = $hitDice;
    }

    public function getHitDice(): Dice
    {
        return $this->hitDice;
    }

    public function setDeathSaves(array $deathSaves): void
    {
        $this->deathSaves = $deathSaves;
    }

    public function getDeathSaves(): array
    {
        return $this->deathSaves;
    }

    public function setAttacks(array $attacks): void
    {
        $this->attacks = $attacks;
    }

    public function getAttacks(): array
    {
        return $this->attacks;
    }

    public function setEquipment(array $equipment): void
    {
        $this->equipment = $equipment;
    }

    public function getEquipment(): array
    {
        return $this->equipment;
    }

    public function setPersonalityTraits(string $personalityTraits): void
    {
        $this->personalityTraits = $personalityTraits;
    }

    public function getPersonalityTraits(): string
    {
        return $this->personalityTraits;
    }

    public function setIdeals(string $ideals): void
    {
        $this->ideals = $ideals;
    }

    public function getIdeals(): string
    {
        return $this->ideals;
    }

    public function setBonds(string $bonds): void
    {
        $this->bonds = $bonds;
    }

    public function getBonds(): string
    {
        return $this->bonds;
    }

    public function setFlaws(string $flaws): void
    {
        $this->flaws = $flaws;
    }

    public function getFlaws(): string
    {
        return $this->flaws;
    }

    public function setFeatures(array $features): void
    {
        $this->features = $features;
    }

    public function getFeatures(): array
    {
        return $this->features;
    }

    public function toString(bool $html = FALSE): string
    {
        if ($html) {
            return '<br>Name: ' . $this->name .
                '<br>Class: ' . $this->class .
                '<br>Level: ' . $this->level .
                '<br>Race: ' . $this->race .
                '<br>Background: ' . $this->background .
                '<br>Alignment: ' . $this->alignment .
                '<br>Experience points: ' . $this->experiencePoints .
                '<br><br>Attributes:<br>' . Functions::arrayToString($this->attributes, $html) .
                '<br><br>Has inspiration: ' . $this->inspiration .
                '<br>Proficiency: ' . $this->proficiency .
                '<br><br>Saving throws:<br>' . Functions::arrayToString($this->savingThrows, $html) .
                '<br><br>Skills:<br>' . Functions::arrayToString($this->skills, $html) .
                '<br><br>Proficiencies and Languages:<br>' . Functions::arrayToString($this->proficienciesAndLanguages, $html) .
                '<br><br>Money:<br>' . Functions::arrayToString($this->money, $html) .
                '<br>Armor: ' . $this->armor .
                '<br>Initiative: ' . $this->initiative .
                '<br>Speed: ' . $this->speed .
                '<br>Current hit points: ' . $this->currentHitPoints .
                '<br>Temporary hit points: ' . $this->temporaryHitPoints .
                '<br>Hit dice: ' . $this->hitDice .
                '<br><br>Death saves:<br>' . Functions::arrayToString($this->deathSaves, $html) .
                '<br><br>Personality traits: ' . $this->personalityTraits .
                '<br>Ideals: ' . $this->ideals .
                '<br>Bonds: ' . $this->bonds .
                '<br>Flaws: ' . $this->flaws .
                '<br><br>Attacks:<br>' . Functions::arrayToString($this->attacks, $html, true) .
                '<br><br>Equipment:<br>' . Functions::arrayToString($this->equipment, $html, true) .
                '<br><br>Features:<br>' . Functions::arrayToString($this->features, $html) .
                '<br>';
        } else {
            return '\nName: ' . $this->name .
                '\nClass: ' . $this->class .
                '\nLevel: ' . $this->level .
                '\nRace: ' . $this->race .
                '\nBackground: ' . $this->background .
                '\nAlignment: ' . $this->alignment .
                '\nExperience points: ' . $this->experiencePoints .
                '\n\nAttributes:\n' . Functions::arrayToString($this->attributes, $html) .
                '\n\nHas inspiration: ' . $this->inspiration .
                '\nProficiency: ' . $this->proficiency .
                '\n\nSaving throws:\n' . Functions::arrayToString($this->savingThrows, $html) .
                '\n\nSkills:\n' . Functions::arrayToString($this->skills, $html) .
                '\n\nProficiencies and Languages:\n' . Functions::arrayToString($this->proficienciesAndLanguages, $html) .
                '\n\nMoney:\n' . Functions::arrayToString($this->money, $html) .
                '\nArmor: ' . $this->armor .
                '\nInitiative: ' . $this->initiative .
                '\nSpeed: ' . $this->speed .
                '\nCurrent hit points: ' . $this->currentHitPoints .
                '\nTemporary hit points: ' . $this->temporaryHitPoints .
                '\nHit dice: ' . $this->hitDice .
                '\n\nDeath saves:\n' . Functions::arrayToString($this->deathSaves, $html) .
                '\n\nPersonality traits: ' . $this->personalityTraits .
                '\nIdeals: ' . $this->ideals .
                '\nBonds: ' . $this->bonds .
                '\nFlaws: ' . $this->flaws .
                '\n\nAttacks:\n' . Functions::arrayToString($this->attacks, $html, true) .
                '\n\nEquipment:\n' . Functions::arrayToString($this->equipment, $html, true) .
                '\n\nFeatures:\n' . Functions::arrayToString($this->features, $html) .
                '\n';
        }
    }

    public function nameCharacter(): self
    {
        if ((substr($this->file, -4) !== 'chr') && !$this->named) {
            $this->file .= "-" . $this->name . ".chr";
            $this->named = true;
        }
        return $this;
    }

    public function hitDiceToString(): string
    {
        return $this->hitDice;
    }

    public function checkLvlUp(): bool
    {
        $lvl_increase = 0;
        $exp_increase = 0;

        for ($i = 1; TRUE; $i++) {
            $exp_increase += $i * 1000;

            if ($this->experiencePoints < $exp_increase) {
                $lvl_increase = $i;
                break;
            }
        }

        if ($lvl_increase > $this->level) {
            $this->level = $lvl_increase;
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function gainExp($experience): string
    {
        $this->experiencePoints += $experience;
        if ($this->checkLvlUp()) {
            return 'You gained ' . $experience . ' experience points.\nYou leveled up to level ' . $this->level . '!';
        } else {
            return 'You gained ' . $experience . ' experience points.';
        }
    }

    public function advanceSkill(string $skill, int $advanceBy = 1): bool
    {
        if (!array_key_exists($skill, $this->skills)) {
            return FALSE;
        } else {
            $this->skills[$skill] += $advanceBy;
            return TRUE;
        }
    }

    public function addAttack(Attack $attack): bool
    {
        if ($attack->getAttackName()) {
            array_push($this->attacks, $attack);
            return true;
        }
        return false;
    }

    public function addToInventory(Equipment $item): bool
    {
        if ($item->getItemName()) {
            array_push($this->equipment, $item);
            return true;
        }
        return false;
    }

    public function addFeature(Feature $feature): bool
    {
        if ($feature->getFeatureName()) {
            array_push($this->features, $feature);
            return true;
        }
        return false;
    }

    public function printAttack(): string
    {
        $str = '';
        foreach ($this->attacks as $attack) {
            $str .= $attack;
        }
        return $str;
    }

    public function printEquipment(): string
    {
        $str = '';
        foreach ($this->equipment as $equipment) {
            $str .= $equipment;
        }
        return $str;
    }

    public function printFeatures(): string
    {
        $str = '';
        foreach ($this->features as $features) {
            $str .= $features;
        }
        return $str;
    }

    public function editFeature(string $feature, string $description): bool
    {
        if (array_key_exists($feature, $this->features)) {
            $this->features[$feature] = $description;
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function advanceAttribute(string $attribute, $advanceBy = 1): bool
    {
        if (!array_key_exists($attribute, $this->attributes)) {
            return FALSE;
        } else {
            $this->attributes[$attribute] += $advanceBy;
            return TRUE;
        }
    }

    public function editProficienciesAndLanguages(string $proficiencyOrLanguage, string $description): bool
    {
        if (array_key_exists($proficiencyOrLanguage, $this->proficienciesAndLanguages)) {
            $this->proficienciesAndLanguages[$proficiencyOrLanguage] = $description;
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function uploadPrepare(): object
    {
        return new CharacterUpload(
            $this->id,
            $this->name,
            $this->class,
            $this->level,
            $this->background,
            $this->race,
            $this->alignment,
            $this->experiencePoints,
            json_encode($this->attributes),
            $this->inspiration,
            $this->proficiency,
            json_encode($this->savingThrows),
            json_encode($this->skills),
            json_encode($this->proficienciesAndLanguages),
            json_encode($this->money),
            $this->armor,
            $this->initiative,
            $this->speed,
            $this->currentHitPoints,
            $this->temporaryHitPoints,
            $this->numberOfDice,
            $this->sidesOfDice,
            json_encode($this->deathSaves),
            json_encode($this->attacks),
            json_encode($this->equipment),
            $this->personalityTraits,
            $this->ideals,
            $this->bonds,
            $this->flaws,
            json_encode($this->features),
            $this->user,
            $this->isPublic,
            $this->file
        );
    }

    public function fileOutput(string $path = '/'): string
    {
        $arr = array(
            $this->name,
            $this->class,
            $this->level,
            $this->background,
            $this->race,
            $this->alignment,
            $this->experiencePoints,
            $this->attributes,
            $this->inspiration,
            $this->proficiency,
            $this->savingThrows,
            $this->skills,
            $this->proficienciesAndLanguages,
            $this->money,
            $this->armor,
            $this->initiative,
            $this->speed,
            $this->currentHitPoints,
            $this->temporaryHitPoints,
            $this->numberOfDice,
            $this->sidesOfDice,
            $this->deathSaves,
            $this->attacks,
            $this->equipment,
            $this->personalityTraits,
            $this->ideals,
            $this->bonds,
            $this->flaws,
            $this->features
        );
        $str = json_encode($arr);
        $handle = fopen(Application::$ROOT_DIR . $path . $this->file, "w");
        fwrite($handle, $str, strlen($str));
        fclose($handle);
        return $this->file;
    }

    public function fileInput(string $stream,): self|false
    {
        $file = json_decode($stream, true);
        return new Character(
            $file[0],
            $file[1],
            $file[2],
            $file[3],
            $file[4],
            $file[5],
            $file[6],
            $file[7],
            $file[8],
            $file[9],
            $file[10],
            $file[11],
            $file[12],
            $file[13],
            $file[14],
            $file[15],
            $file[16],
            $file[17],
            $file[18],
            $file[19],
            $file[20],
            $file[21],
            $file[22],
            $file[23],
            $file[24],
            $file[25],
            $file[26],
            $file[27],
            $file[28]
        );
    }

    public function isPublic(): bool
    {
        if ($this->isPublic) {
            return true;
        } else {
            return false;
        }
    }

    public function getFile(): string
    {
        return $this->file;
    }

    public function setFile($file): void
    {
        $this->file = $file;
    }
}

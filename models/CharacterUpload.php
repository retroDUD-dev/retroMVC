<?php

namespace app\models;

use app\core\db\DbModel;

class CharacterUpload extends DbModel
{
    public function __construct(
        public int $id = 0,
        public string $name = '',
        public string $class = '',
        public int $level = 0,
        public string $background = '',
        public string $race = '',
        public string $alignment = '',
        public int $experiencePoints = 0,
        public string $attributes = '',
        public int $inspiration = 0,
        public int $proficiency = 0,
        public string $savingThrows = '',
        public string $skills = '',
        public string $proficienciesAndLanguages = '',
        public string $money = '',
        public int $armor = 0,
        public int $initiative = 0,
        public int $speed = 0,
        public int $currentHitPoints = 0,
        public int $temporaryHitPoints = 0,
        public int $numberOfDice = 0,
        public int $sidesOfDice = 0,
        public string $deathSaves = '',
        public string $attacks = '',
        public string $equipment = '',
        public string $personalityTraits = '',
        public string $ideals = '',
        public string $bonds = '',
        public string $flaws = '',
        public string $features = '',
        public string $user = '',
        public int $isPublic = 0,
        public string $file = ''
    ) {
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

    public static function tableName(): string
    {
        return 'Characters';
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function rules(): array
    {
        return [];
    }
    
    public function downloadPrepare(): object
    {
        return new Character(
            $this->name,
            $this->class,
            $this->level,
            $this->background,
            $this->race,
            $this->alignment,
            $this->experiencePoints,
            json_decode($this->attributes) ?? [],
            $this->inspiration,
            $this->proficiency,
            json_decode($this->savingThrows) ?? [],
            json_decode($this->skills) ?? [],
            json_decode($this->proficienciesAndLanguages) ?? [],
            json_decode($this->money) ?? [],
            $this->armor,
            $this->initiative,
            $this->speed,
            $this->currentHitPoints,
            $this->temporaryHitPoints,
            $this->numberOfDice,
            $this->sidesOfDice,
            json_decode($this->deathSaves) ?? [],
            json_decode($this->attacks) ?? [],
            json_decode($this->equipment) ?? [],
            $this->personalityTraits,
            $this->ideals,
            $this->bonds,
            $this->flaws,
            json_decode($this->features) ?? [],
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
}

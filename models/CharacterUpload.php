<?php

namespace app\models;

use app\core\Application;
use app\core\db\DbModel;

class CharacterUpload extends DbModel
{
    public function __construct()
    {
    }
    public string $name = '';
    public string $class = '';
    public int $level = 0;
    public string $background = '';
    public string $race = '';
    public string $alignment = '';
    public int $experiencePoints = 0;
    public string $attributes = '';
    public int $inspiration = 0;
    public int $proficiency = 0;
    public string $savingThrows = '';
    public string $skills = '';
    public string $proficienciesAndLanguages = '';
    public string $money = '';
    public int $armor = 0;
    public int $initiative = 0;
    public int $speed = 0;
    public int $currentHitPoints = 0;
    public int $temporaryHitPoints = 0;
    public int $numberOfDice = 0;
    public int $sidesOfDice = 0;
    public string $deathSaves = '';
    public string $attacks = '';
    public string $equipment = '';
    public string $personalityTraits = '';
    public string $ideals = '';
    public string $bonds = '';
    public string $flaws = '';
    public string $features = '';
    public string $user = '';
    public int $isPublic = 0;
    public string $file = '';

    public function attributes(): array
    {
        return [
            'id',
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
        $characterDownload =  new Character();
            $characterDownload->id = $this->id;
            $characterDownload->name = $this->name;
            $characterDownload->class = $this->class;
            $characterDownload->level = $this->level;
            $characterDownload->background = $this->background;
            $characterDownload->race = $this->race;
            $characterDownload->alignment = $this->alignment;
            $characterDownload->experiencePoints = $this->experiencePoints;
            $characterDownload->attributes = json_decode($this->attributes, true) ?? [];
            $characterDownload->inspiration = $this->inspiration;
            $characterDownload->proficiency = $this->proficiency;
            $characterDownload->savingThrows = json_decode($this->savingThrows, true) ?? [];
            $characterDownload->skills = json_decode($this->skills, true) ?? [];
            $characterDownload->proficienciesAndLanguages = json_decode($this->proficienciesAndLanguages, true) ?? [];
            $characterDownload->money = json_decode($this->money, true) ?? [];
            $characterDownload->armor = $this->armor;
            $characterDownload->initiative = $this->initiative;
            $characterDownload->speed = $this->speed;
            $characterDownload->currentHitPoints = $this->currentHitPoints;
            $characterDownload->temporaryHitPoints = $this->temporaryHitPoints;
            $characterDownload->numberOfDice = $this->numberOfDice;
            $characterDownload->sidesOfDice = $this->sidesOfDice;
            $characterDownload->deathSaves = json_decode($this->deathSaves, true) ?? [];
            $characterDownload->attacks = json_decode($this->attacks, true) ?? [];
            $characterDownload->equipment = json_decode($this->equipment, true) ?? [];
            $characterDownload->personalityTraits = $this->personalityTraits;
            $characterDownload->ideals = $this->ideals;
            $characterDownload->bonds = $this->bonds;
            $characterDownload->flaws = $this->flaws;
            $characterDownload->features = json_decode($this->features, true) ?? [];
            $characterDownload->user = $this->user;
            $characterDownload->isPublic = $this->isPublic;
            $characterDownload->file = $this->file;
        return $characterDownload;
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

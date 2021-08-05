<?php

namespace app\models;

use \PDO;
use app\core\Application;
use app\core\db\DbModel;

class CharacterSearch extends DbModel
{
    public function __construct()
    {
    }

    public string $searchByName;
    public string $searchByClass;
    public string $searchByLevel;
    public string $searchByUser;
    public string $searchOnlyMine;
    public string $file = '';
    public string $user = '';
    public string $isPublic = '';

    public static function tableName(): string
    {
        return 'Characters';
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function attributes(): array
    {
        return [
            'searchByName',
            'searchByClass',
            'searchByLevel',
            'searchByUser',
            'searchOnlyMine',
            'file'
        ];
    }

    public function rules(): array
    {
        return [];
    }

    public function getLabel($attribute): string
    {
        if (str_contains($attribute, 'characterPreview')) {
            $attribute = 'characterPreview';
        }
        if (str_contains($attribute, 'delete')) {
            $attribute = 'delete';
        }

        return $this->labels()[$attribute] ?? $attribute;
    }

    public function labels(): array
    {
        return [
            'searchByName' => 'Character name: ',
            'searchByClass' => 'Class: ',
            'searchByLevel' => 'Level: ',
            'searchByUser' => 'Created by: ',
            'searchOnlyMine' => 'Only show my Characters: ',
            'search' => '',
            'characterPreview' => '',
            'delete' => ''
        ];
    }
}

<?php

namespace app\models;

use app\core\Application;
use app\core\UserModel;
use PDO;

class UserSearch extends UserModel
{
    public function __construct()
    {
    }

    public string $searchById = '';
    public string $searchByDisplayName = '';
    public string $searchByFirstname = '';
    public string $searchByLastname = '';
    public string $searchByEmail = '';
    public string $searchByStatus = '';
    public string $userSearch = '';

    public static function tableName(): string
    {
        return 'users';
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function attributes(): array
    {
        return [
            'searchById',
            'searchByDisplayName',
            'searchByFirstname',
            'searchByLastname',
            'searchByEmail',
            'searchByStatus'
        ];
    }

    public function labels(): array
    {
        return [
            'searchById' => 'ID: ',
            'searchByDisplayName' => 'Display name: ',
            'searchByFirstname' => 'Name: ',
            'searchByLastname' => 'Lastname: ',
            'searchByEmail' => 'Email: ',
            'searchByStatus' => 'Status: ',
            'edit' => '',
            'delete' => '',
            'userSearch' => ''
        ];
    }

    public function rules(): array
    {
        return [];
    }

    public function getLabel($attribute): string
    {
        if (str_contains($attribute, 'edit')) {
            $attribute = 'edit';
        }
        if (str_contains($attribute, 'delete')) {
            $attribute = 'delete';
        }

        return $this->labels()[$attribute] ?? $attribute;
    }

    public function getDisplayName(): string
    {
        return $this->displayName;
    }
}

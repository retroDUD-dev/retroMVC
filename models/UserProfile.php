<?php

namespace app\models;

use app\core\Application;

class UserProfile extends User
{
    public string $firstname = '';
    public string $lastname = '';
    public string $email = '';
    public string $edit;
    public string $save;
    public string $deactivate;
    public string $delete;
    public string $resetPassword;

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
            'id',
            'firstname',
            'lastname',
            'email',
            'resetPassword',
            'edit',
            'deactivate',
            'delete',
        ];
    }

    public function rules(): array
    {
        return [
            'firstname' => [self::RULE_REQUIRED],
            'lastname' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => self::class]],
        ];
    }

    public function labels(): array
    {
        return [
            'firstname' => 'First name',
            'lastname' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'resetPassword' => '',
            'edit' => '',
            'deactivate' => '',
            'delete' => '',
            'save' => ''
        ];
    }

    public function getDisplayName(): string
    {
        return $this->firstname;
    }
}

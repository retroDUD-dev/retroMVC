<?php

namespace app\models;

use app\core\UserModel;

class User extends UserModel
{
    public function __construct()
    {
    }

    public string $displayName = '';
    public string $firstname = '';
    public string $lastname = '';
    public string $email = '';
    public string $password = '';
    public string $confirmPassword = '';

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
            'displayName',
            'firstname',
            'lastname',
            'email',
            'password',
            'status'
        ];
    }

    public function rules(): array
    {
        return [
            'displayName' => [self::RULE_REQUIRED],
            'firstname' => [self::RULE_REQUIRED],
            'lastname' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => self::class]],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8]],
            'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']]
        ];
    }

    public function save(): void
    {
        $this->status = self::STATUS_ACTIVE;
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        parent::save();
    }

    public function labels(): array
    {
        return [
            'displayName' => 'Display name',
            'firstname' => 'First name',
            'lastname' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'confirmPassword' => 'Confirm password',
            'resetPassword' => '',
            'login' => '',
            'edit' => '',
            'save' => '',
            'deactivate' => '',
            'delete' => '',
            'register' => ''
        ];
    }

    public function getDisplayName(): string
    {
        return $this->displayName;
    }
}

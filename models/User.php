<?php

namespace app\models;

use app\core\UserModel;

class User extends UserModel
{
    public function __construct()
    {
    }

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
            'delete' => ''
        ];
    }

    public function getDisplayName(): string
    {
        return $this->firstname;
    }
}

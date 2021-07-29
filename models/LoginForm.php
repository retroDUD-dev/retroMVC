<?php

namespace app\models;

use app\core\db\DbModel;

class LoginForm extends DbModel
{
    public function __construct(
        public string $email = '',
        public string $password = ''
    ) {
    }

    public function attributes(): array
    {
        return [
            'email',
            'password'
        ];
    }

    public function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED]
        ];
    }

    public static function tableName(): string
    {
        return 'users';
    }

    public function primaryKey(): string
    {
        return 'email';
    }

    public function labels(): array
    {
        return [
            'email' => 'Email: ',
            'password' => 'Password: ',
            'login' => ''
        ];
    }
}

<?php

namespace app\models;

use app\core\db\DbModel;

class ResetPasswordForm extends DbModel
{
    public function __construct(
        public string $oldPassword = '',
        public string $newPassword = '',
        public string $confirmNewPassword = ''
    ) {
    }

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
            'oldPassword',
            'newPassword',
            'confirmNewPassword'
        ];
    }

    public function rules(): array
    {
        return [
            'oldPassword' => [self::RULE_REQUIRED],
            'newPassword' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8]],
            'confirmNewPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'newPassword']]
        ];
    }

    public function labels(): array
    {
        return [
            'oldPassword' => 'Current password: ',
            'newPassword' => 'New password: ',
            'confirmNewPassword' => 'Confirm new password: ',
            'submit' => ''
        ];
    }
}

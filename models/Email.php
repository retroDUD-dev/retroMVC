<?php

namespace app\models;

use app\core\Model;

class Email extends Model
{
    public function __construct(
        public string $firstName = '',
        public string $lastName = '',
        public string $email = '',
        public string $subject = ''
    ) {
    }

    public function attributes(): array
    {
        return [
            'firstName',
            'lastName',
            'email',
            'subject',
            'submit'
        ];
    }

    public function rules(): array
    {
        return [
            'firstName' => [self::RULE_REQUIRED],
            'lastName' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'subject' => [self::RULE_REQUIRED]
        ];
    }

    public function labels(): array
    {
        return [
            'firstName' => 'First name: ',
            'lastName' => 'Last name: ',
            'email' => 'Email: ',
            'subject' => 'Message: ',
            'submit' => ''
        ];
    }

    public function send(): void
    {
        mail('info@retroDUD.eu', "New message from " . $this->firstname . " " . $this->lastname, $this->subject, "from: " . $this->email);
    }
}

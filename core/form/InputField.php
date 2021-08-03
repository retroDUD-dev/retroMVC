<?php

namespace app\core\form;

use app\core\Model;

class InputField extends BaseField
{
    public const TYPE_TEXT = 'text';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_NUMBER = 'number';
    public const TYPE_RADIO = 'radio';
    public const TYPE_EMAIL = 'email';
    public const TYPE_FILE = 'file';
    public const TYPE_CHECKBOX = 'checkbox';

    public function __construct(
        public Model $model,
        public string $attribute = '',
        private string $form = '',
        private mixed $value = '',
        private string $custom = ''
        ) {
        }
        
        private string $type = self::TYPE_TEXT;
        private mixed $defaultValue = '';

    public function passwordField(): object
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

    public function numberField(): object
    {
        $this->defaultValue = 0;
        $this->type = self::TYPE_NUMBER;
        return $this;
    }

    public function radioField(): object
    {
        $this->type = self::TYPE_RADIO;
        return $this;
    }

    public function checkField(): object
    {
        $this->type = self::TYPE_CHECKBOX;
        return $this;
    }

    public function emailField(): object
    {
        $this->type = self::TYPE_EMAIL;
        return $this;
    }

    public function fileField(): object
    {
        $this->type = self::TYPE_FILE;
        return $this;
    }

    public function renderInput(): string
    {
        return sprintf(
            '<input type="%s" name="%s" class="input %s" form="%s" value="%s" %s>',
            $this->type,
            $this->attribute,
            $this->model->hasErrors($this->attribute) ? 'invalid' : '',
            $this->form,
            $this->value !== '' ? $this->value : $this->defaultValue,
            $this->custom
        );
    }
}

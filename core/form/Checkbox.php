<?php

namespace app\core\form;

use app\core\Model;

class Checkbox extends BaseField
{
    public function __construct(
        public Model $model,
        public string $attribute = '',
        private string $form = '',
        private string $value = '',
        private string $custom = ''
    ){

    }

    public function renderInput(): string
    {
        return sprintf(
            '<input type="checkbox" name="%s" class="input %s" form="%s" value="%s" %s>',
            $this->attribute,
            $this->model->hasErrors($this->attribute) ? 'invalid' : '',
            $this->form,
            $this->value,
            $this->custom
        );
    }
}
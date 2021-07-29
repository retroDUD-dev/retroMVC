<?php

namespace app\core\form;

use app\core\Model;

class Button extends BaseField
{
    public function __construct(
        public Model $model,
        public string $attribute = '',
        private string $form = '',
        private string $buttonName = '',
        private string $custom = ''
    ){

    }

    public function renderInput(): string
    {
        return sprintf(
            '<input type="submit" name="%s" class="submit button %s" form="%s" value="%s" %s>',
            $this->attribute,
            $this->model->hasErrors($this->attribute) ? 'invalid' : '',
            $this->form,
            $this->buttonName,
            $this->custom
        );
    }
}
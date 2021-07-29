<?php

namespace app\core\form;

use app\core\Model;

class Textarea extends BaseField
{

    public function __construct(
        public Model $model,
        public string $attribute = '',
        private string $form = '', 
        private string $custom = ''
    ) {
    }

    public function renderInput(): string
    {
        return sprintf(
            '<textarea name="%s" class="input %s" form="%s" %s>%s</textarea>',
            $this->attribute,
            $this->model->hasErrors($this->attribute) ? 'invalid' : '',
            $this->form,
            $this->custom,
            $this->model->{$this->attribute} ?? ''
        );
    }
}

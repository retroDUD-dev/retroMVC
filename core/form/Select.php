<?php

namespace app\core\form;

use app\core\Model;

class Select extends BaseField
{

    public function __construct(
        public Model $model,
        public string $attribute = '',
        private string $form = '',
        private array $items = array(),
        private string $custom = ''
    ) {
    }

    public function renderInput(): string
    {
        $select = "<select name='%s' class='input %s' form='%s' %s>\n";
        foreach ($this->items as $itemName => $item) {
            $select .= "<option value='$itemName'>$item</option>\n";
        }
        $select .= "</select>\n";

        return sprintf(
            $select,
            $this->attribute,
            $this->model->hasErrors($this->attribute) ? 'invalid' : '',
            $this->form,
            $this->custom
        );
    }
}

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
        //     <select id="cars" name="cars">
        //       <option value="volvo">Volvo</option>
        //       <option value="saab">Saab</option>
        //       <option value="fiat">Fiat</option>
        //       <option value="audi">Audi</option>
        //     </select>
        //         '<textarea name="%s" class="input %s" form="%s" %s>%s</textarea>'


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

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

        $select;

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

<?php

namespace app\core\form;

use app\core\Model;

abstract class BaseField
{

    public function __toString()
    {
        return sprintf(
            '
            <span class="error">%s</span>
            <label class="text name">%s</label>
            %s
            ',
            $this->model->getFirstError($this->attribute),
            $this->model->getLabel($this->attribute) ?? ucfirst($this->attribute),
            $this->renderInput()
        );
    }

    abstract public function renderInput(): string;
}

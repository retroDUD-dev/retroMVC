<?php

namespace app\core\form;

use app\core\Model;

class Form
{
    private static string $id = '';

    public static function begin($id, $action, $method, string $custom = ''): void
    {
        self::$id = $id;
        echo sprintf('<form id="%s" action="%s" method="%s" %s>', $id, $action, $method, $custom);
    }

    public static function end(): void
    {
        echo '</form>';
    }

    public static function inputField(Model $model, string $attribute, string $type = 'text', string $custom = ''): object
    {
        echo $inputField = new InputField($model, $attribute, self::$id, $type, $custom);
        return $inputField;
    }
    
    public static function button(Model $model, string $attribute, string $custom = ''): object
    {
        echo $button = new Button($model, $attribute, self::$id, $custom);
        return $button;
    }
    
    public static function checkbox(Model $model, string $attribute, string $value = '', string $custom = ''): object
    {
        echo $button = new Checkbox($model, $attribute, self::$id, $value, $custom);
        return $button;
    }
    
    public static function radio(Model $model, string $attribute, string $value = '', string $custom = ''): object
    {
        echo $radio = new Radio($model, $attribute, self::$id, $value, $custom);
        return $radio;
    }
    
        public static function textarea(Model $model, string $attribute, string $custom = ''): object
        {
            echo $textarea = new Textarea($model, $attribute, self::$id, $custom);
            return $textarea;
        }

        public static function select(Model $model, string $attribute, array $items, string $custom = ''): object
        {
            echo $select = new Select($model, $attribute, self::$id, $items, $custom);
            return $select;
        }
}

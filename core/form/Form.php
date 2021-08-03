<?php

namespace app\core\form;

use app\core\Model;

class Form
{
    private static string $id = '';

    public static function begin($id, $action, $method, string $custom = ''): string
    {
        self::$id = $id;
        return sprintf('<form id="%s" action="%s" method="%s" %s>', $id, $action, $method, $custom);
    }

    public static function end(): string
    {
        return '</form>';
    }

    public static function inputField(Model $model, string $attribute, string $value = '', string $custom = ''): object
    {
        return new InputField($model, $attribute, self::$id, $value, $custom);
    }

    public static function button(Model $model, string $attribute, string $value, string $custom = ''): object
    {
        return new Button($model, $attribute, self::$id, $value, $custom);
    }

    public static function textarea(Model $model, string $attribute, string $custom = ''): object
    {
        return new Textarea($model, $attribute, self::$id, $custom);
    }

    public static function select(Model $model, string $attribute, array $items, string $custom = ''): object
    {
        return new Select($model, $attribute, self::$id, $items, $custom);
    }
}

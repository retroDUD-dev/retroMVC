<?php

namespace app\core;

abstract class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';
    public const RULE_NUMBER = 'number';

    public array $errors = array();

    abstract public function attributes(): array;
    abstract public function rules(): array;

    public function loadData(array $data): void
    {
        foreach ($data as $key => $value) {
            $pos = strpos($key, '/');
            if ($pos) {
                $array = substr($key, 0, $pos);
                $key = substr($key, 1);
                if (property_exists($this, $array)) {
                    $this->{$array}['key'] = $value;
                }
            }
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public function getLabel($attribute): string
    {
        return $this->labels()[$attribute] ?? $attribute;
    }

    public function labels(): array
    {
        return array();
    }

    public function validate(): bool
    {
        foreach ($this->rules() as $attribute => $rules) {
            $pos = strpos($attribute, '/');
            if ($pos) {
                $array = substr($attribute, 0, $pos);
                $attribute = substr($attribute, $pos + 1);
                $value = $this->{$array}[$attribute];
            } else {
                $value = $this->{$attribute};
            }
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (is_array($ruleName)) {
                    $ruleName = $rule[0];
                }

                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addRuleError($attribute, self::RULE_REQUIRED);
                }
                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addRuleError($attribute, self::RULE_EMAIL);
                }
                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addRuleError($attribute, self::RULE_MIN, $rule);
                }
                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addRuleError($attribute, self::RULE_MAX, $rule);
                }
                if ($ruleName === self::RULE_MATCH && $value != $this->{$rule['match']}) {
                    $rule['match'] = strtolower($this->getLabel($rule['match']));
                    $this->addRuleError($attribute, self::RULE_MATCH, $rule);
                }
                if ($ruleName === self::RULE_UNIQUE) {
                    $className = $rule['class'];
                    $uniqueAttribute = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();
                    $statement = Application::$APP->db->prepare("SELECT * FROM $tableName WHERE $uniqueAttribute = :attribute AND id != ".Application::$APP->session->get('user')['primaryValue']."");
                    $statement->bindValue(":attribute", $value);
                    $statement->execute();
                    $record = $statement->fetchObject();
                    if ($record) {
                        $this->addRuleError($attribute, self::RULE_UNIQUE, ['unique' => strtolower($this->getLabel($attribute))]);
                    }
                }
                if ($ruleName === self::RULE_NUMBER && !is_numeric($value)) {
                    $this->addRuleError($attribute, self::RULE_NUMBER, $rule);
                }
            }
        }

        return empty($this->errors);
    }

    public function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => '<br>This field is required<br>',
            self::RULE_EMAIL => '<br>Invalid email format<br>',
            self::RULE_MIN => '<br>Min length is {min}<br>',
            self::RULE_MAX => '<br>Max length is {max}<br>',
            self::RULE_MATCH => '<br>This field must match {match}<br>',
            self::RULE_UNIQUE => '<br>{unique} already in use<br>',
            self::RULE_NUMBER => '<br>Numbers only<br>'
        ];
    }

    public function hasErrors($attribute): array|false
    {
        return $this->errors[$attribute] ?? false;
    }

    protected function addRuleError(string $attribute, string $rule, $params = array()): void
    {
        $message = $this->errorMessages()[$rule] ?? '';
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attribute][$rule] = $message;
    }

    protected function addError(string $attribute, string $message): void
    {
        $this->errors[$attribute][] = $message;
    }

    public function getFirstError(string $attribute): string|false
    {
        if (is_array($this->errors[$attribute])) {
            return array_values($this->errors[$attribute])[0];
        }
        return $this->errors[$attribute] ?? false;
    }

    public function getTypedFalse(string $type): mixed
    {
        switch ($type) {
            case 'number':
                return 0;
            default:
                return '';
        }
    }
}

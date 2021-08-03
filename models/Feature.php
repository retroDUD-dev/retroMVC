<?php

namespace app\models;

use app\core\Model;

class Feature extends Model
{
    public function __construct(
        public string $featureName = '',
        public string $description = ''
    ) {
    }

    public string $addMore = '';
    public string $addLast = '';

    public function __toString(): string
    {
        return $this->featureName . ": " . $this->description . "\n";
    }

    public function attributes(): array
    {
        return [
            'featureName',
            'description'
        ];
    }

    public function rules(): array
    {
        return array(
            'featureName' => [self::RULE_REQUIRED]
        );
    }

    public function labels(): array
    {
        return [
            'featureName' => 'Feature: ',
            'description' => 'Description: ',
            'addMore' => ''
        ];
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription($description): void
    {
        $this->description = $description;
    }

    public function getFeatureName(): string
    {
        return $this->featureName;
    }

    public function setFeatureName($featureName): void
    {
        $this->featureName = $featureName;
    }

    public function addLast(): void
    {
        $this->addMore = '';
        $this->addLast = '';
    }
}

<?php

namespace app\models;

use app\core\Model;

class Dice extends Model
{
    public function __construct(
        protected int $number = 0,
        protected int $sides = 0
    ) {
    }

    function __toString(): string
    {
        return $this->number . "d" . $this->sides;
    }

    public function attributes(): array
    {
        return [
            'number',
            'sides'
        ];
    }

    public function rules(): array
    {
        return array();
    }

    function setNumber(int $number): void
    {
        $this->number = $number;
    }

    function getNumber(): int
    {
        return $this->number;
    }

    function setSides(int $sides): void
    {
        $this->sides = $sides;
    }

    function getSides(): int
    {
        return $this->sides;
    }

    function roll(): int
    {
        $r = 0;
        for ($i = 0; $i < $this->number; $i++) {
            $r += rand(1, $this->sides);
        }
        return $r;
    }
}

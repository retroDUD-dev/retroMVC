<?php

namespace app\models;

use app\core\Model;
use app\models\Dice;

class Attack extends Model
{
    public function __construct(
        public string $attackName = "",
        public int $bonus = 0,
        public int $numberOfDice = 0,
        public int $sidesOfDice = 0,
        public string $type = "",
        public string $comment = ""
    ) {
        $this->attackDice = new Dice($numberOfDice, $sidesOfDice);
    }

    public string $addMore = '';
    public string $addLast = '';

    private Dice $attackDice;

    public function __toString(): string
    {
        return "
        Attack name: " . $this->attackName . "\n
        Attack bonus: " . $this->bonus . "\n
        Attack dice: " . $this->attackDice . "\n
        Attack type: " . $this->type . "\n
        Comment: " . $this->comment . "\n
        ";
    }

    public function attributes(): array
    {
        return [
            'attackName',
            'bonus',
            'numberOfDice',
            'sidesOfDice',
            'type',
            'comment'

        ];
    }

    public function rules(): array
    {
        return array(
            'attackName' => [self::RULE_REQUIRED],
            'bonus' => [self::RULE_NUMBER],
            'numberOfDice' => [self::RULE_NUMBER],
            'sidesOfDice' => [self::RULE_NUMBER],
        );
    }

    public function labels(): array
    {
        return [
            'attackName' => 'Attack name: ',
            'bonus' => 'Attack bonus: ',
            'numberOfDice' => 'Hit Dice: ',
            'sidesOfDice' => ' d',
            'type' => 'Attack type',
            'comment' => 'Comment: '
        ];
    }

    public function setAttackName(string $attackName): void
    {
        $this->attackName = $attackName;
    }

    public function getAttackName(): string
    {
        return $this->attackName;
    }

    public function setBonus(int $bonus): void
    {
        $this->bonus = $bonus;
    }

    public function getBonus(): int
    {
        return $this->bonus;
    }

    public function getNumberOfDice(): int
    {
        return $this->numberOfDice;
    }

    public function setNumberOfDice($numberOfDice): void
    {
        $this->numberOfDice = $numberOfDice;
    }

    public function getSidesOfDice(): int
    {
        return $this->sidesOfDice;
    }

    public function setSidesOfDice($sidesOfDice): void
    {
        $this->sidesOfDice = $sidesOfDice;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType($type): void
    {
        $this->type = $type;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment($comment): void
    {
        $this->comment = $comment;
    }

    public function addLast(): void
    {
        $this->addMore = '';
        $this->addLast = '';
    }
}

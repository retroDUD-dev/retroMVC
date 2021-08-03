<?php

namespace app\models;

use app\core\Model;

class Equipment extends Model
{
    public function __construct(
        public string $itemName = '',
        public int $quantity = 0
    ) {
    }

    public string $addMore = '';
    public string $addLast = '';

    public function __toString(): string
    {
        return "
        Item name: " . $this->itemName . "
        (quantity: " . $this->bonus . ")\n
        ";
    }

    public function attributes(): array
    {
        return [
            'itemName',
            'quantity'
        ];
    }

    public function rules(): array
    {
        return array(
            'itemName' => [self::RULE_REQUIRED],
            'quantity' => [self::RULE_NUMBER]
        );
    }

    public function labels(): array
    {
        return [
            'itemName' => 'Item: ',
            'quantity' => 'Quantity: ',
            'addMore' => ''
        ];
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity($quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getItemName(): string
    {
        return $this->itemName;
    }

    public function setItemName($itemName): void
    {
        $this->itemName = $itemName;
    }

    public function addLast(): void
    {
        $this->addMore = '';
        $this->addLast = '';
    }
}

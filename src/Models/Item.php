<?php
declare(strict_types=1);

namespace TestApp\Models;

final class Item
{
    public function __construct(
        public string $name,
        public float $price,
        public int $quantity
    ) {
    }

    public function getTotal(): float
    {
        return $this->price * $this->quantity;
    }
}
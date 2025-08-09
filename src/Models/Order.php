<?php

namespace TestApp\Models;

class Order
{
    /** @var Item[] */
    public array $items = [];

    public function __construct(
        public Customer $customer,
        public \DateTimeImmutable $deliveryDate
    ) {
    }

    public function addItem(Item $item): void
    {
        $this->items[] = $item;
    }

    public function getItemsCount(): int
    {
        $count = 0;
        foreach ($this->items as $item) {
            $count += $item->quantity;
        }
        return $count;
    }

    public function getSubtotal(): float
    {
        $sum = 0.0;
        foreach ($this->items as $item) {
            $sum += $item->getTotal();
        }
        return $sum;
    }
}
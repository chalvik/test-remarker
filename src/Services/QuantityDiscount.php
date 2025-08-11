<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\Interfaces\DiscountInterface;
use App\Models\Order;

class QuantityDiscount implements DiscountInterface
{
    private float $rate = 0.03; // 3%

    public function getName(): string
    {
        return 'quantity';
    }

    public function apply(float $currentAmount, Order $order): array
    {
        if ($order->getItemsCount() > 10) {
            $deduction = $currentAmount * $this->rate;
            $after = $currentAmount - $deduction;
            return [$after, $deduction, $this->rate];
        }
        return [$currentAmount, 0.0, 0.0];
    }
}
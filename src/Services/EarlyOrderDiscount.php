<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\Interfaces\DiscountInterface;
use App\Models\Order;

class EarlyOrderDiscount implements DiscountInterface
{
    private float $rate = 0.04; // 4%

    public function getName(): string
    {
        return 'early_order';
    }

    public function apply(float $currentAmount, Order $order): array
    {
        $now = new \DateTimeImmutable('now');
        // if delivery_date is at least 7 days (week) ahead from now => discount
        $interval = $now->diff($order->deliveryDate);

        // diff->days gives absolute days; check if delivery is in future and >=7
        if ($order->deliveryDate <= $now) {
            return [$currentAmount, 0.0, 0.0];
        }
        if ($interval->days >= 7) {
            $deduction = $currentAmount * $this->rate;
            $after = $currentAmount - $deduction;
            return [$after, $deduction, $this->rate];
        }
        return [$currentAmount, 0.0, 0.0];
    }
}

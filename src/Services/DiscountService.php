<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Order;

final class DiscountService
{
    public function __construct(
        public array $discounts
    ) {
    }

    public function applyAll(Order $order): array
    {
        $subtotal = $order->getSubtotal();
        $current = $subtotal;
        $breakdown = [];
        foreach ($this->discounts as $d) {
            [$after, $appliedAmount, $rate] = $d->apply($current, $order);
            if ($appliedAmount > 0.0) {
                $breakdown[] = [
                    'name' => $d->getName(),
                    'rate' => $rate,
                    'amount' => round($appliedAmount, 2),
                    'before' => round($current, 2),
                    'after' => round($after, 2),
                ];
            }
            $current = $after;
        }

        return [
            'subtotal' => round($subtotal, 2),
            'total' => round($current, 2),
            'discounts' => $breakdown,
        ];
    }
}
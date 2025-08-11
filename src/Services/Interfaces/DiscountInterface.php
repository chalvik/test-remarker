<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use App\Models\Order;

interface DiscountInterface
{
    public function apply(float $currentAmount, Order $order): array;

    public function getName(): string;
}
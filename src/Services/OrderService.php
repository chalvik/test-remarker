<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Order;

readonly class OrderService
{
    public function __construct(public array $discounts)
    {
    }

    public function applyAll(Order $order): array
    {
        return [];
    }
}
<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\Interfaces\DiscountInterface;
use App\Models\Order;

class PensionerDiscount implements DiscountInterface
{
    private float $rate = 0.05; // 5%

    public function getName(): string
    {
        return 'pensioner';
    }

    public function apply(float $currentAmount, Order $order): array
    {
        $now = new \DateTimeImmutable('now');
        $age = $order->customer->getAgeAt($now);
        $gender = $order->customer->gender;
        $isPensioner = $this->isPensioner(age: $age, gender: $gender);

        if ($isPensioner) {
            $deduction = $currentAmount * $this->rate;
            $after = $currentAmount - $deduction;
            return [$after, $deduction, $this->rate];
        } else {
            return [$currentAmount, 0.0, 0.0];
        }
    }

    private function isPensioner($age, $gender): bool
    {
        if (in_array($gender, ['male', 'm'])) {
            $isPensioner = $age >= 63;
        } else {
            $isPensioner = $age >= 58;
        }
        return $isPensioner;
    }
}
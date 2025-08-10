<?php

declare(strict_types=1);

namespace App\Models;

final class Customer
{
    public function __construct(
        public string $gender,
        public \DateTimeImmutable $birthDate
    ) {
    }

    public function getAgeAt(\DateTimeImmutable $at): int
    {
        $diff = $this->birthDate->diff($at);
        return (int)$diff->y;
    }
}
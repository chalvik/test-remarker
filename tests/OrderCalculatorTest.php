<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Order;
use App\Services\DiscountService;
use App\Services\PensionerDiscount;
use App\Services\EarlyOrderDiscount;
use App\Services\QuantityDiscount;

final class OrderCalculatorTest extends TestCase
{
    private function createCalculator(): DiscountService
    {
        return new DiscountService([
            new PensionerDiscount(),
            new EarlyOrderDiscount(),
            new QuantityDiscount(),
        ]);
    }

    public function testPensionerDiscount(): void
    {
        $customer = new Customer(gender: "m", birthDate: new DateTimeImmutable('1950-01-01'));
        $order = new Order($customer, new DateTimeImmutable('+2 days'));
        $order->addItem(new Item(name: 'Item 1', price: 100, quantity: 1));

        $calc = $this->createCalculator();
        $total = $calc->applyAll($order);

        $this->assertEquals(95.0, $total['total'] ?? 0); // 5% скидка
    }

    public function testEarlyOrderDiscount(): void
    {
        $customer = new Customer(gender: "female", birthDate: new DateTimeImmutable('1990-01-01'));
        $order = new Order($customer, new DateTimeImmutable('+8 days'));
        $order->addItem(new Item(name: 'Item 1', price: 100, quantity: 1));

        $calc = $this->createCalculator();
        $total = $calc->applyAll($order);

        $this->assertEquals(96.0, $total['total'] ?? 0); // 4% скидка
    }

    public function testQuantityDiscount(): void
    {
        $customer = new Customer(gender: "female", birthDate: new DateTimeImmutable('1990-01-01'));
        $order = new Order($customer, new DateTimeImmutable('+2 days'));
        $order->addItem(new Item(name: 'Item 1', price: 10, quantity: 11));
        $calc = $this->createCalculator();
        $total = $calc->applyAll($order);
        $this->assertEquals(106.7, $total['total'] ?? 0); // 3% скидка
    }

    public function testAllDiscountsTogether(): void
    {
        $customer = new Customer(gender: "male", birthDate: new DateTimeImmutable('1950-01-01'));
        $order = new Order($customer, new DateTimeImmutable('+8 days'));
        $order->addItem(new Item(name: 'Item 1', price: 10, quantity: 11));

        $calc = $this->createCalculator();
        $total = $calc->applyAll($order);

        // ручной расчёт: base=110, -5% = 104.5, -4% = 100.32, -3% = 97.3104
        $this->assertEquals(97.31, round($total['total'] ?? 0, 2));
    }
}

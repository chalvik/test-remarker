<?php

declare(strict_types=1);

namespace App\Validators;

use App\Exceptions\ValidationException;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Order;

class PayloadValidator
{
    /**
     * @param array $data
     * @return Order
     * @throws ValidationException
     */
    public static function validate(array $data): Order
    {
// required fields:
// buyer (birth_date, gender),  - покупатель
// delivery_date - дата доставки
// items (array) - товары  (price, quantity)

        if (!isset($data['buyer']) || !is_array($data['buyer'])) {
            throw new ValidationException('Missing or invalid "buyer"');
        }
        $buyer = $data['buyer'];

        if (!isset($buyer['birth_date']) || !is_string($buyer['birth_date'])) {
            throw new ValidationException('Missing or invalid buyer.birth_date');
        }
        if (!isset($buyer['gender']) || !is_string($buyer['gender'])) {
            throw new ValidationException('Missing or invalid buyer.gender');
        }

        try {
            $birthDate = new \DateTimeImmutable($buyer['birth_date']);
        } catch (\Exception $e) {
            throw new ValidationException('Invalid birth_date format, expect ISO date');
        }

        $gender = strtolower($buyer['gender']);
        if (!in_array($gender, ['male', 'female', 'm', 'f'], true)) {
            throw new ValidationException('Invalid gender, expect "male" or "female"');
        }

        if (!isset($data['delivery_date']) || !is_string($data['delivery_date'])) {
            print_r($data['delivery_date']);
            throw new ValidationException('Missing or invalid delivery_date');
        }

        try {
            $deliveryDate = new \DateTimeImmutable($data['delivery_date']);
        } catch (\Exception $e) {
            throw new ValidationException('Invalid delivery_date format, expect ISO datetime');
        }

        if (!isset($data['items']) || !is_array($data['items']) || count($data['items']) === 0) {
            throw new ValidationException('Missing or empty items');
        }

        $customer = new Customer($gender, $birthDate);
        $order = new Order($customer, $deliveryDate);

        foreach ($data['items'] as $key => $item) {
            if (!is_array($item)) {
                throw new ValidationException("Item #{$key} invalid");
            }
            if (!isset($item['price']) || !is_numeric($item['price'])) {
                throw new ValidationException("Item #{$key} missing price");
            }
            if (!isset($item['quantity']) || !is_int($item['quantity'])) {
                throw new ValidationException("Item #{$key} missing quantity (int)");
            }
            $name = $item['name'] ?? "item_{$key}";
            $price = (float)$item['price'];
            $quantity = $item['quantity'];
            if ($price < 0 || $quantity <= 0) {
                throw new ValidationException("Item #{$key} has invalid price/quantity");
            }
            $order->addItem(new Item($name, $price, $quantity));
        }

        return $order;
    }
}
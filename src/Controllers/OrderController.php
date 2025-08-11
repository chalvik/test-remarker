<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Exceptions\ValidationException;
use App\Services\DiscountService;
use App\Validators\PayloadValidator;

final class OrderController
{
    public function calc(): void
    {
        header('Content-Type: application/json');
        $raw = file_get_contents('php://input');
        if (!$raw) {
            http_response_code(400);
            echo json_encode(['error' => 'Empty body']);
            return;
        }

        $data = json_decode($raw, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON: ' . json_last_error_msg()]);
            return;
        }

        try {
            $order = PayloadValidator::validate($data);
        } catch (ValidationException $e) {
            http_response_code(422);
            echo json_encode(['error' => $e->getMessage()]);
            return;
        }

        $discountService = new DiscountService([]);

        $result = $discountService->applyAll($order);
        http_response_code(200);
        echo json_encode($result);
    }
}
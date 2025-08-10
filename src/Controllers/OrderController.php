<?php

declare(strict_types=1);

namespace App\Controllers;

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

        /** To Do Service  */
        $result = [];
        echo json_encode($result);
    }
}
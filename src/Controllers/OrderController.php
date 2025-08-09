<?php

namespace TestApp\Controllers;

class OrderController
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
        $result = $data;
        echo json_encode($result);
    }
}
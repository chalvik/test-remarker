<?php
//  REST API
// Usage: POST /order/calc with JSON body

declare(strict_types=1);

// --------------------------------------------------
//  router
// --------------------------------------------------
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

if ($uri === '/order/calc' && $method === 'POST') {
    (new \TestApp\Controllers\OrderController())->calc();
    exit;
}
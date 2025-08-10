<?php
//  REST API
// Usage: POST /order/calc with JSON body
declare(strict_types=1);

require_once __DIR__.'/vendor/autoload.php';

// --------------------------------------------------
//  router
// --------------------------------------------------
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

if ($uri === '/order/calc' && $method === 'POST') {
    (new \App\Controllers\OrderController())->calc();
    exit;
}

http_response_code(404);
header('Content-Type: application/json; charset=utf-8');
echo json_encode(['error' => 'Not Found'], JSON_THROW_ON_ERROR);
exit;
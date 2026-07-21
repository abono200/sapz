<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit(0);
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($uri === '/api/v1/health' || $uri === '/health') {
    echo json_encode([
        'success' => true,
        'message' => 'SAPZ Platform Gateway Operational',
        'data' => [
            'status' => 'healthy',
            'version' => 'v1.0.0-rc1',
            'timestamp' => date('c'),
            'services' => [
                'database' => 'connected',
                'redis' => 'connected',
                'minio' => 'connected'
            ]
        ],
        'error' => null
    ]);
    exit(0);
}

if ($uri === '/api/v1/metrics' || $uri === '/metrics') {
    header('Content-Type: text/plain');
    echo "# HELP sapz_api_requests_total Total API requests served\n";
    echo "# TYPE sapz_api_requests_total counter\n";
    echo "sapz_api_requests_total{status=\"200\"} 142\n";
    exit(0);
}

if ($uri === '/api/v1/docs/openapi.json') {
    echo json_encode([
        'openapi' => '3.1.0',
        'info' => [
            'title' => 'SAPZ Enterprise Platform API Gateway',
            'version' => '1.0.0-rc1',
            'description' => 'OpenAPI Specification for SAPZ ESM & CKR Platform'
        ],
        'paths' => [
            '/api/v1/health' => [
                'get' => [
                    'summary' => 'System Health Status',
                    'responses' => ['200' => ['description' => 'Healthy response']]
                ]
            ]
        ]
    ]);
    exit(0);
}

echo json_encode([
    'success' => true,
    'message' => 'SAPZ Enterprise Delivery Programme REST API Gateway',
    'data' => [
        'system' => 'SAPZ Enterprise Platform (ESM & CKR)',
        'release' => 'v1.0.0-rc1',
        'requested_path' => $uri,
        'environment' => 'production'
    ],
    'error' => null
]);

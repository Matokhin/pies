<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use App\PirozhokRepository;

header('Content-Type: application/json');

$repo = new PirozhokRepository();

$filters = [
    'fillings' => $_GET['fillings'] ?? [],
    'dough'    => $_GET['dough'] ?? null,
    'sort'     => $_GET['sort'] ?? null,
    'limit'    => (int) ($_GET['limit'] ?? 5),
    'offset'   => (int) ($_GET['offset'] ?? 0),
];

try {
    $data = $repo->getAll($filters);
    echo json_encode($data);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Ошибка сервера']);
}



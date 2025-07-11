<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use App\PirozhokRepository;
use App\Validator;

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$errors = Validator::validate($data);

if (!empty($errors)) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'errors' => $errors
    ]);
    exit;
}

$repo = new PirozhokRepository();
$success = $repo->add($data);

if ($success) {
    echo json_encode(['status' => 'success']);
} else {
    http_response_code(500);
    echo json_encode(['status' => 'fail', 'message' => 'Не удалось сохранить пирожок']);
}
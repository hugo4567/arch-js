<?php
header('Content-Type: application/json; charset=utf-8');

function respond(array $payload, int $status = 200): never {
    http_response_code($status);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond(['success' => false, 'message' => 'Method not allowed'], 405);
}

$levelId = $_POST['id'] ?? '';
if (!is_string($levelId) || !preg_match('/^[a-zA-Z0-9_-]+$/', $levelId)) {
    respond(['success' => false, 'message' => 'Invalid level ID'], 400);
}

$jsonPath = __DIR__ . "/../../levels/{$levelId}.json";
if (!is_file($jsonPath)) {
    respond(['success' => false, 'message' => 'Level file not found'], 404);
}

$scriptDir = __DIR__ . '/../Scripts';
$command = sprintf(
    'cd %s && node %s %s 2>&1',
    escapeshellarg($scriptDir),
    escapeshellarg('screenshot.js'),
    escapeshellarg($levelId)
);

$output = [];
$exitCode = 0;
exec($command, $output, $exitCode);

$pngPath = __DIR__ . "/../../levels/{$levelId}.png";
if ($exitCode !== 0 || !is_file($pngPath)) {
    error_log("Thumbnail generation failed for {$levelId}: " . implode("\n", $output));
    respond(['success' => false, 'message' => 'Thumbnail generation failed'], 500);
}

respond(['success' => true, 'path' => "/levels/{$levelId}.png"]);

<?php
header('Content-Type: application/json; charset=utf-8');

$levelsDir = __DIR__ . '/../../levels';
$levels = [];

foreach (glob($levelsDir . '/*.json') ?: [] as $path) {
    $id = basename($path, '.json');
    $levels[] = ['id' => $id, 'name' => $id];
}

usort($levels, static fn($left, $right) => strnatcasecmp($left['name'], $right['name']));
echo json_encode($levels, JSON_UNESCAPED_UNICODE);

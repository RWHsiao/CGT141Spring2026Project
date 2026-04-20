<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Credentials: true");
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
$origin = rtrim($origin, '/');

$allowed = [
    "http://localhost",
    "https://localhost",
    "http://localhost:8000",
    "https://playvideogames.me",
    "https://www.playvideogames.me"
];

if (!$origin) {
    header("Access-Control-Allow-Origin: https://localhost");
} elseif (in_array($origin, $allowed)) {
    header("Access-Control-Allow-Origin: $origin");
} else {
    header("Access-Control-Allow-Origin: https://playvideogames.me");
}
header("Access-Control-Allow-Credentials: true");
header("Vary: Origin");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}
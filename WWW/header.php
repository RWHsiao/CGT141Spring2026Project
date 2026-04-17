<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Credentials: true");
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';

$allowed = [
    "http://localhost:8000",
    "https://playvideogames.me",
    "https://www.playvideogames.me"
];

if (in_array($origin, $allowed)) {
    header("Access-Control-Allow-Origin: $origin");
    header("Access-Control-Allow-Credentials: true");
}
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Credentials: true");
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';

$allowed = [
    "http://localhost:8000",
    "https://playvideogames.me"
];

if (in_array($origin, $allowed)) {
    header("Access-Control-Allow-Origin: $origin");
    header("Access-Control-Allow-Credentials: true");
}
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
session_start();
include __DIR__ . "/../database.php";
include __DIR__ . "/../game_variants.php";

$gameName = $_GET['game'];
$variant = $_GET['variant'];
$_SESSION['current_game'] = $gameName;
$_SESSION['current_variant'] = $variant;

$settings = $games[$gameName][$variant] ?? null;
if (!$settings) {
    die("Invalid game or variant");
}

$script = $settings['script'];
unset($settings['script']);

$result = [
    "gameName" => $gameName,
    "variant" => $variant,
    "settings" => $settings,
    "script" => $script
];

echo json_encode($result);

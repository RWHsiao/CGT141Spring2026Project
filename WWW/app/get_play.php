<?php
include __DIR__ . "/../header.php";
require_once __DIR__ . "/../session.php";
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

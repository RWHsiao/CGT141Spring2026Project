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
header('Content-Type: application/json');
include "database.php";

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];
$game_name = $_SESSION['current_game'];
$variant = $_SESSION['current_variant'];

$data = json_decode(file_get_contents('php://input'), true);
$score = isset($data['score']) ? intval($data['score']) : 0;

$stmt = $conn->prepare("
    INSERT INTO scores (user_id, game_name, variant, score) 
    VALUES (?, ?, ?, ?)
");
$stmt->bind_param("issi", $user_id, $game_name, $variant, $score);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error']);
}

$stmt->close();
$conn->close();

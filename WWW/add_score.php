<?php
include "header.php";
require_once "session.php";
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

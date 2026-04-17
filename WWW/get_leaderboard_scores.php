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
include "database.php";

$game_name = $_GET['game_name'];
$variant = $_GET['variant'];

$sql = "SELECT u.username, u.pfp, s.score
        FROM scores s
        JOIN users u ON s.user_id = u.id
        WHERE s.game_name = ? AND s.variant = ?
        ORDER BY s.score DESC
        LIMIT 10";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("ss", $game_name, $variant);

$stmt->execute();


$result = $stmt->get_result();

$scores = [];

while ($row = $result->fetch_assoc()) {
    $scores[] = $row;
}

echo json_encode($scores);

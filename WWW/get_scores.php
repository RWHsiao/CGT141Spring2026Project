<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include "database.php";

$game_name = $_GET['game_name'];
$variant = $_GET['variant'];

$sql = "SELECT u.username, s.score
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
?>
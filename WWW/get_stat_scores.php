<?php
include "header.php";
include "database.php";

$game_name = $_GET['game_name'];
$variant = $_GET['variant'];
$user_id = $_GET['user_id'];

$sql = "SELECT score
        FROM scores
        WHERE game_name = ? AND variant = ? AND user_id = ?
        ORDER BY score DESC
        LIMIT 10";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("ssi", $game_name, $variant, $user_id);
$stmt->execute();

$result = $stmt->get_result();

$scores = [];

while ($row = $result->fetch_assoc()) {
    $scores[] = $row;
}

echo json_encode($scores);

<?php
include __DIR__ . "/../header.php";

require_once __DIR__ . "/../session.php";
session_unset();
session_destroy();

echo json_encode(["success" => true]);
exit;
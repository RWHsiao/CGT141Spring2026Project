<?php
$host = 'localhost';
$user = 'webuser';
$password = 'Password$123!';
$database_name = 'site_database';

$conn = new mysqli($host, $user, $password, $database_name);

if ($conn->connect_error) {
    die("Login system database error: " . $conn->connect_error);
}

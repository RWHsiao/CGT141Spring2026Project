<?php
$host = 'localhost';
$user = 'webuser';
$password = 'Password$123!';
$database_name = 'site_database';

$conn_login = new mysqli($host, $user, $password, $database_name);
if ($conn_login->connect_error) {
    die("Login system database error: ".$conn_login->connect_error);
}
?>
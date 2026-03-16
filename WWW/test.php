<?php
include "database.php";

if ($conn) {
    echo "Database connected successfully!";
} else {
    echo "Failed to connect to database.";
}
?>
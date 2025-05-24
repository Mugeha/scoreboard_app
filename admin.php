<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "db.php";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully to MySQL!";
?>

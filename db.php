<?php
$host = getenv('DB_HOST');
$username = getenv('DB_USER');
$password = getenv('DB_PASS');
$database = getenv('DB_NAME');
$port = getenv('DB_PORT');

// Set up SSL context (TiDB requires secure connection)
$mysqli = mysqli_init();
$mysqli->ssl_set(null, null, null, null, null); // Enables default SSL

// Connect with SSL
$mysqli->real_connect($host, $username, $password, $database, (int)$port, null, MYSQLI_CLIENT_SSL);

if ($mysqli->connect_errno) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>

<?php
require_once __DIR__ . '/Config.php';

$config = new Config();

$conn = new mysqli($config->server_name, $config->username, $config->password, $config->db_name, $config->port);

if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

echo "✅ Connected successfully!";

<?php
// Load environment variables
if (!file_exists(__DIR__.'/.env')) {
    die('Please create .env file');
}

$env = parse_ini_file(__DIR__.'/.env');

// Database Connection
$conn = new mysqli($env['DB_HOST'], $env['DB_USER'], $env['DB_PASS'], $env['DB_NAME']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// File Upload Settings
define('UPLOAD_DIR', __DIR__ . '/' . $env['UPLOAD_DIR']);
define('MAX_FILE_SIZE', (int)$env['MAX_FILE_SIZE']);
define('ALLOWED_TYPES', explode(',', $env['ALLOWED_TYPES']));

// Auto create upload directory
if (!file_exists(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0755, true);
}
?>
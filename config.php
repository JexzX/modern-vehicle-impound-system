<?php
// Load .env
if (!file_exists(__DIR__.'/.env')) die("File .env tidak ditemukan");
$env = parse_ini_file(__DIR__.'/.env');

// Database Connection
$conn = new mysqli(
    $env['DB_HOST'],
    $env['DB_USER'],
    $env['DB_PASS'],
    $env['DB_NAME']
);

if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// Upload Settings
define('UPLOAD_DIR', __DIR__ . '/' . $env['UPLOAD_DIR']);
define('MAX_FILE_SIZE', (int)$env['MAX_FILE_SIZE']);
define('ALLOWED_TYPES', explode(',', $env['ALLOWED_TYPES']));

// Buat folder upload jika belum ada
if (!file_exists(UPLOAD_DIR)) {
    if (!mkdir(UPLOAD_DIR, 0755, true)) {
        die("Gagal membuat folder upload");
    }
}

// Fungsi dasar
function sanitize($data) {
    return htmlspecialchars(trim($data));
}
?>
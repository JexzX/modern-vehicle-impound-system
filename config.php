<?php
// Load .env manually (tanpa Composer)
$envPath = __DIR__ . '/.env';
if (file_exists($envPath)) {
    $env = parse_ini_file($envPath);
} else {
    die("File .env tidak ditemukan! Buat file .env terlebih dahulu.");
}

// Koneksi database
$conn = new mysqli(
    $env['DB_HOST'],
    $env['DB_USER'],
    $env['DB_PASS'],
    $env['DB_NAME']
);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Contoh query (opsional)
// $result = $conn->query("SELECT * FROM vehicles");
?>
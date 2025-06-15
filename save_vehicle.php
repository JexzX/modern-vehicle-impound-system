<?php
include 'config.php';

$vehicle_type = $_POST['vehicle_type'];
$plate_number = $_POST['plate_number'];
$reason = $_POST['reason'];
$impound_duration = $_POST['impound_duration'];

// Hitung expiry_date (contoh: +7 hari dari sekarang)
$days = (int) $impound_duration; // Jika input "7 hari"
$expiry_date = date('Y-m-d H:i:s', strtotime("+$days days"));

$sql = "INSERT INTO impounded_vehicles (vehicle_type, plate_number, reason, impound_duration, expiry_date) 
        VALUES ('$vehicle_type', '$plate_number', '$reason', '$impound_duration', '$expiry_date')";

if ($conn->query($sql) === TRUE) {
    header("Location: index.php?success=1");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
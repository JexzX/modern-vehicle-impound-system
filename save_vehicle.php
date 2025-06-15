<?php
require 'config.php';

// Debug
error_log("Data POST: " . print_r($_POST, true));
error_log("Data FILES: " . print_r($_FILES, true));

// Validasi dasar
if (empty($_POST['plate_number'])) {
    die("Nomor plat harus diisi");
}

// Simpan file (versi sederhana)
$uploaded = [];
if (!empty($_FILES['proofs']['tmp_name'][0])) {
    $target = UPLOAD_DIR . '/' . $_POST['plate_number'] . '_' . basename($_FILES['proofs']['name'][0]);
    if (move_uploaded_file($_FILES['proofs']['tmp_name'][0], $target)) {
        $uploaded[] = basename($target);
    }
}

// Simpan ke database
$sql = "INSERT INTO impounded_vehicles (
    vehicle_type, plate_number, color, reason,
    impound_duration, officer, owner, proofs
) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$proofs_json = json_encode($uploaded);
$stmt->bind_param(
    "ssssssss",
    $_POST['vehicle_type'],
    $_POST['plate_number'],
    $_POST['color'],
    $_POST['reason'],
    $_POST['impound_duration'],
    $_POST['officer'],
    $_POST['owner'],
    $proofs_json
);

if ($stmt->execute()) {
    header("Location: index.php?success=1");
} else {
    echo "Error: " . $stmt->error;
    error_log("Database error: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>
<?php
include 'config.php';

// 1. Setup Upload Directory
$uploadDir = __DIR__ . '/uploads/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// 2. Handle File Uploads
function handleUpload($file, $uploadDir, $plate) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxSize = 5 * 1024 * 1024; // 5MB
    
    if (!in_array($file['type'], $allowedTypes)) {
        return ['error' => 'Only JPG, PNG, GIF allowed'];
    }
    
    if ($file['size'] > $maxSize) {
        return ['error' => 'File too large (max 5MB)'];
    }
    
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = $plate . '_' . uniqid() . '.' . $ext;
    $targetPath = $uploadDir . $filename;
    
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return ['filename' => $filename];
    } else {
        return ['error' => 'Upload failed'];
    }
}

// 3. Process Main Data
$plate_number = trim($_POST['plate_number']);
$proof1 = handleUpload($_FILES['proof1'], $uploadDir, $plate_number);
$proof2 = isset($_FILES['proof2']) ? handleUpload($_FILES['proof2'], $uploadDir, $plate_number) : null;

// 4. Validate
$errors = [];
if (isset($proof1['error'])) $errors[] = "Proof 1: " . $proof1['error'];
if ($proof2 && isset($proof2['error'])) $errors[] = "Proof 2: " . $proof2['error'];

if (!empty($errors)) {
    die("<div style='max-width:600px;margin:2rem auto;padding:1rem;background:#fee2e2;border-radius:8px;'>
            <h3 style='color:#b91c1c;'>Upload Error</h3>
            <ul>" . implode('', array_map(fn($e) => "<li>$e</li>", $errors)) . "</ul>
            <a href='add.php' style='color:#3b82f6;'>← Back to form</a>
        </div>");
}

// 5. Save to Database
$stmt = $conn->prepare("INSERT INTO impounded_vehicles (
    vehicle_type, plate_number, reason, impound_duration,
    expiry_date, color, officer, owner, status,
    proof1, proof2, timestamp
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

// Calculate expiry date
$duration = $_POST['impound_duration'];
$expiry_date = ($duration === 'Permanent') ? null : date('Y-m-d H:i:s', strtotime("+$duration"));

$stmt->bind_param("sssssssssss",
    $_POST['vehicle_type'],
    $plate_number,
    $_POST['reason'],
    $duration,
    $expiry_date,
    $_POST['color'],
    $_POST['officer'],
    $_POST['owner'],
    'Impounded',
    $proof1['filename'],
    $proof2 ? $proof2['filename'] : null
);

if ($stmt->execute()) {
    header("Location: index.php?success=1");
} else {
    die("Database error: " . $conn->error);
}

$stmt->close();
$conn->close();
?>
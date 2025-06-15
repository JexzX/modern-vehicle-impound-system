<?php
include 'config.php';

$id = (int)$_GET['id'];

// Get proofs to delete files
$stmt = $conn->prepare("SELECT proofs FROM impounded_vehicles WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$proofs = json_decode($stmt->get_result()->fetch_assoc()['proofs'], true);

// Delete files
foreach ($proofs as $file) {
    @unlink(UPLOAD_DIR . '/' . $file);
}

// Delete record
$stmt = $conn->prepare("DELETE FROM impounded_vehicles WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: index.php?deleted=1");
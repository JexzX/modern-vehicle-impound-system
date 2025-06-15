<?php
include 'config.php';

$plate_number = $_GET['plate'];

$sql = "DELETE FROM impounded_vehicles WHERE plate_number='$plate_number'";

if ($conn->query($sql) === TRUE) {
    header("Location: index.php?deleted=1");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
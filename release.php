<?php
include 'config.php';

$id = (int)$_GET['id'];
$stmt = $conn->prepare("UPDATE impounded_vehicles SET status='Released' WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: detail.php?id=$id&released=1");
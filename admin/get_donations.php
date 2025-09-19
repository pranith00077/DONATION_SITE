<?php
include 'config.php';

header('Content-Type: application/json');

$sql = "SELECT id, name, email, phone, amount, donation_type AS type, created_at FROM donations ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

$donations = [];

while ($row = mysqli_fetch_assoc($result)) {
    $donations[] = $row;
}

echo json_encode($donations);
?>

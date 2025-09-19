<?php
include 'config.php'; // adjust path

$result = $conn->query("SELECT id, title FROM stories ORDER BY id DESC");
$stories = [];

while ($row = $result->fetch_assoc()) {
    $stories[] = $row;
}

header('Content-Type: application/json');
echo json_encode($stories);
?>

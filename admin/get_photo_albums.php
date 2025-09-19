<?php
// admin/get_photo_albums.php

header('Content-Type: application/json');
include 'db_connect.php';

$albums = [];
$sql = "SELECT id, title, description, cover_image_path, created_at FROM albums ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Adjust path for frontend display if necessary
        // Assuming 'uploads' is in the root, and this script is in 'admin/'
        $row['cover_image_path'] = str_replace('../', '', $row['cover_image_path']);
        $albums[] = $row;
    }
}

$conn->close();
echo json_encode($albums);
?>

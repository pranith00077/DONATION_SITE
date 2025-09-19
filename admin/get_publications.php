<?php
header('Content-Type: application/json');
include 'config.php'; // adjust if your config file is elsewhere

$result = mysqli_query($conn, "SELECT * FROM publications ORDER BY published_at DESC");

$publications = [];

while ($row = mysqli_fetch_assoc($result)) {
    $publications[] = [
        'id' => $row['id'],
        'title' => $row['title'],
        'description' => $row['description'],
        'pdf_file' => $row['pdf_file'],
        'cover_image' => $row['cover_image'],
        'published_at' => $row['published_at']
    ];
}

echo json_encode($publications);

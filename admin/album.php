<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "ngo_site");

if ($conn->connect_error) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT id, title, description, cover_image FROM gallery_albums ORDER BY id DESC";
$result = $conn->query($sql);

$albums = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        if (!empty($row['cover_image'])) {
            $row['cover_image'] = "admin/uploads/covers/" . $row['cover_image'];
        } else {
            $row['cover_image'] = "images/default_album.jpg"; // fallback
        }
        $albums[] = $row;
    }
}

echo json_encode($albums);
$conn->close();
?>

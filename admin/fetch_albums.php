<?php
header('Content-Type: application/json');
$mysqli = new mysqli('localhost', 'root', '', 'ngo_site');
if ($mysqli->connect_errno) {
    echo json_encode([]);
    exit();
}

$sql = "SELECT id, title, description, cover_image FROM gallery_albums ORDER BY id DESC";
$result = $mysqli->query($sql);
$albums = [];

while ($row = $result->fetch_assoc()) {
    if (!empty($row['cover_image'])) {
        // If DB already stores full path with 'uploads/albums/covers/', just prepend 'admin/' once
        if (strpos($row['cover_image'], 'uploads/albums/covers/') !== false) {
            $row['cover_image'] = 'admin/' . $row['cover_image'];
        } else {
            // Otherwise, build the correct path
            $row['cover_image'] = 'admin/uploads/albums/covers/' . $row['cover_image'];
        }
    } else {
        $row['cover_image'] = 'assets/default.jpg'; // fallback
    }

    $albums[] = $row;
}

echo json_encode($albums);
$mysqli->close();
?>

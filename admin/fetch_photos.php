<?php
header('Content-Type: application/json');
$mysqli = new mysqli('localhost', 'root', '', 'ngo_site');
if ($mysqli->connect_errno) {
    echo json_encode(["error" => "DB connection failed"]);
    exit();
}

if (isset($_GET['album_id'])) {
    $album_id = intval($_GET['album_id']);
    $sql = "SELECT id, album_id, image_path, uploaded_at FROM gallery_photos 
            WHERE album_id = $album_id ORDER BY uploaded_at DESC";
    $result = $mysqli->query($sql);

    $photos = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            if (!empty($row['image_path'])) {
                // ✅ Use image_path directly from DB
                $row['photo'] = '/website/' . ltrim($row['image_path'], '/');
            } else {
                $row['photo'] = '/website/assets/default.jpg';
            }
            $photos[] = $row;
        }
    } else {
        $photos[] = ["error" => $mysqli->error];
    }

    echo json_encode($photos);
} else {
    echo json_encode(["error" => "album_id missing"]);
}

$mysqli->close();
?>

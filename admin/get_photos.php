<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "ngo_site");

if ($conn->connect_error) {
    echo json_encode([]);
    exit;
}

$album_id = isset($_GET['album_id']) ? intval($_GET['album_id']) : 0;
if ($album_id <= 0) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT id, file FROM gallery_photos WHERE album_id = $album_id ORDER BY id ASC";
$result = $conn->query($sql);

$photos = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        if (!empty($row['file'])) {
            $row['file'] = "admin/uploads/photos/" . $row['file'];
        }
        $photos[] = $row;
    }
}

echo json_encode($photos);
$conn->close();
?>

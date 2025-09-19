<?php
error_reporting(E_ERROR | E_PARSE);
require_once __DIR__ . '/config.php';

$albumId = isset($_GET['album_id']) ? intval($_GET['album_id']) : 0;
if ($albumId <= 0) { echo json_encode([]); exit; }

$stmt = $conn->prepare("SELECT id, image_path FROM gallery_photos WHERE album_id = ?");
$stmt->bind_param("i", $albumId);
$stmt->execute();
$result = $stmt->get_result();

$photos = [];
while ($row = $result->fetch_assoc()) {
    $row['image_path'] = $row['image_path']; // already stored as relative path
    $photos[] = $row;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($photos);
exit;

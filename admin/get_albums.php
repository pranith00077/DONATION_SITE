<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Content-Type: application/json");

require_once __DIR__ . "/db_conn.php";

// query albums
$query = "SELECT id, title, description, cover_image, created_at 
          FROM gallery_albums 
          ORDER BY created_at DESC";
$result = $conn->query($query);

if (!$result) {
    echo json_encode(["error" => $conn->error]);
    exit;
}

$albums = [];
while ($album = $result->fetch_assoc()) {
    $album['id'] = (int)$album['id'];

    // Normalize cover image path
    $cover = ltrim($album['cover_image'], "/");
    if (strpos($cover, "admin/") !== 0) {
        // If "admin/" is missing, add it
        $cover = "admin/" . $cover;
    }
    $album['cover_image'] = $cover;

    // Fetch photos for this album
    $photosQuery = $conn->prepare("SELECT image_path FROM gallery_photos WHERE id = ?");
    if ($photosQuery) {
        // ⚠️ currently gallery_photos has no album_id → just placeholder
        $photosQuery->bind_param("i", $album['id']);
        $photosQuery->execute();
        $photosResult = $photosQuery->get_result();

        $photos = [];
        while ($row = $photosResult->fetch_assoc()) {
            $img = ltrim($row['image_path'], "/");
            if (strpos($img, "admin/") !== 0) {
                $img = "admin/" . $img;
            }
            $photos[] = $img;
        }
        $album['photos'] = $photos;
    } else {
        $album['photos'] = [];
    }

    $albums[] = $album;
}

echo json_encode($albums);

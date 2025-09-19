<?php
// admin/delete_photo_album.php

header('Content-Type: application/json');
include 'db_connect.php';

$response = ['success' => false, 'message' => ''];

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? null;

if ($id === null || !is_numeric($id)) {
    $response['message'] = 'Invalid album ID.';
    echo json_encode($response);
    exit();
}

// First, get cover image path to delete the file
$stmt = $conn->prepare("SELECT cover_image_path FROM albums WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($cover_image_path);
$stmt->fetch();
$stmt->close();

// Delete album from database (this will also delete associated images due to CASCADE)
$stmt = $conn->prepare("DELETE FROM albums WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        // Delete cover image file from server
        if (!empty($cover_image_path) && file_exists($cover_image_path)) {
            unlink($cover_image_path);
        }

        // Also delete all associated album image files
        // This requires a separate query as CASCADE only handles database rows, not files
        $stmt_images = $conn->prepare("SELECT file_path FROM album_images WHERE album_id = ?");
        $stmt_images->bind_param("i", $id);
        $stmt_images->execute();
        $result_images = $stmt_images->get_result();
        while($row_image = $result_images->fetch_assoc()) {
            if (file_exists($row_image['file_path'])) {
                unlink($row_image['file_path']);
            }
        }
        $stmt_images->close();

        $response['success'] = true;
        $response['message'] = 'Album and its images deleted successfully!';
    } else {
        $response['message'] = 'Album not found.';
    }
} else {
    $response['message'] = 'Database error: ' . $stmt->error;
}

$stmt->close();
$conn->close();
echo json_encode($response);
?>

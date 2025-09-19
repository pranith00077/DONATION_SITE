<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');
ob_start();
require_once 'db_conn.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['success' => false, 'error' => 'POST method required']);
        exit;
    }

    // Replace $_POST keys with actual sent keys
    $id = isset($_POST['photo_id']) ? intval($_POST['photo_id']) : 0; // For photo
    //$id = isset($_POST['album_id']) ? intval($_POST['album_id']) : 0; // For album

    if ($id <= 0) {
        echo json_encode(['success' => false, 'error' => 'Invalid ID']);
        exit;
    }

    // Check DB connection
    if (!$conn) {
        echo json_encode(['success' => false, 'error' => 'DB connection failed']);
        exit;
    }

    // Example: delete photo
    $stmt = $conn->prepare("SELECT file_path FROM gallery_photos WHERE id=?");
    $stmt->execute([$id]);
    $photo = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$photo) {
        echo json_encode(['success' => false, 'error' => 'Photo not found']);
        exit;
    }

    // Delete file
    if (file_exists($photo['file_path'])) {
        if (!unlink($photo['file_path'])) {
            echo json_encode(['success' => false, 'error' => 'Failed to delete file']);
            exit;
        }
    }

    // Delete DB entry
    $stmtDel = $conn->prepare("DELETE FROM gallery_photos WHERE id=?");
    if ($stmtDel->execute([$id])) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'DB delete failed']);
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
exit;

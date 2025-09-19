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

    $photo_id = isset($_POST['photo_id']) ? intval($_POST['photo_id']) : 0;

    if ($photo_id <= 0) {
        echo json_encode(['success' => false, 'error' => 'Invalid photo ID']);
        exit;
    }

    // Get photo path
    $stmt = $conn->prepare("SELECT file_path FROM gallery_photos WHERE id = ?");
    $stmt->execute([$photo_id]);
    $photo = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$photo) {
        echo json_encode(['success' => false, 'error' => 'Photo not found']);
        exit;
    }

    // Delete file from server
    if (file_exists($photo['file_path'])) {
        unlink($photo['file_path']);
    }

    // Delete from database
    $stmt = $conn->prepare("DELETE FROM gallery_photos WHERE id = ?");
    if ($stmt->execute([$photo_id])) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'DB delete failed']);
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
exit;

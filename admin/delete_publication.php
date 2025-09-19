<?php
include 'config.php';
header('Content-Type: application/json');

// Read JSON body
$data = json_decode(file_get_contents("php://input"), true);
$publicationId = $data['id'] ?? null;

if (!$publicationId) {
    echo json_encode(['success' => false, 'message' => 'Missing publication ID']);
    exit;
}

// Get file paths to delete associated files
$stmt = $conn->prepare("SELECT pdf_file, cover_image FROM publications WHERE id = ?");
$stmt->bind_param("i", $publicationId);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // Delete files from server
    if (!empty($row['pdf_file']) && file_exists("../" . $row['pdf_file'])) {
        unlink("../" . $row['pdf_file']);
    }
    if (!empty($row['cover_image']) && file_exists("../" . $row['cover_image'])) {
        unlink("../" . $row['cover_image']);
    }
}

// Delete DB record
$stmt = $conn->prepare("DELETE FROM publications WHERE id = ?");
$stmt->bind_param("i", $publicationId);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Publication deleted successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Deletion failed']);
}
?>

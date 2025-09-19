<?php
include 'config.php';
header('Content-Type: application/json');

$title = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';
$published_at = $_POST['published_at'] ?? '';
$file_path = '';
$cover_image_path = '';

if (!$title || !$published_at) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

// Upload PDF file
if (isset($_FILES['file']) && $_FILES['file']['error'] === 0) {
    $pdfDir = "../uploads/publications/";
    if (!file_exists($pdfDir)) mkdir($pdfDir, 0777, true);

    $pdfName = uniqid() . '_' . basename($_FILES['file']['name']);
    $pdfPath = $pdfDir . $pdfName;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $pdfPath)) {
        $file_path = "uploads/publications/" . $pdfName;
    } else {
        echo json_encode(['success' => false, 'message' => 'PDF upload failed']);
        exit;
    }
}

// Upload Cover Image
if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === 0) {
    $imageDir = "../uploads/publications/";
    $imageName = uniqid() . '_' . basename($_FILES['cover_image']['name']);
    $imagePath = $imageDir . $imageName;

    if (move_uploaded_file($_FILES['cover_image']['tmp_name'], $imagePath)) {
        $cover_image_path = "uploads/publications/" . $imageName;
    } else {
        echo json_encode(['success' => false, 'message' => 'Cover image upload failed']);
        exit;
    }
}
$stmt = $conn->prepare("INSERT INTO publications (title, description, pdf_file, published_at, cover_image) VALUES (?, ?, ?, ?, ?)");

$stmt->bind_param("sssss", $title, $description, $file_path, $published_at, $cover_image_path);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Publication uploaded successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'DB error: ' . $stmt->error]);
}
?>

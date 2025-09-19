<?php
header('Content-Type: application/json');

// Connect to database
$conn = new mysqli("localhost", "root", "", "ngo_site");
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit;
}

// Check required fields
if (
    !isset($_POST['title']) || trim($_POST['title']) === '' ||
    !isset($_POST['content']) || trim($_POST['content']) === '' ||
    !isset($_FILES['image']) || $_FILES['image']['error'] !== 0
) {
    echo json_encode(['success' => false, 'message' => 'All fields (title, content, image) are required.']);
    exit;
}

// Sanitize input
$title = $conn->real_escape_string(trim($_POST['title']));
$content = $conn->real_escape_string(trim($_POST['content']));

// Image handling
$image = $_FILES['image'];
$imageExt = pathinfo($image['name'], PATHINFO_EXTENSION);
$imageName = time() . '_' . uniqid() . '.' . $imageExt;
$targetDir = '../images/';
$targetPath = $targetDir . $imageName;

// Ensure upload directory exists
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

// Move uploaded file
if (!move_uploaded_file($image['tmp_name'], $targetPath)) {
    echo json_encode(['success' => false, 'message' => 'Image upload failed.']);
    exit;
}

// Insert into database
$stmt = $conn->prepare("INSERT INTO stories (title, content, image, created_at) VALUES (?, ?, ?, NOW())");
$stmt->bind_param("sss", $title, $content, $imageName);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Story added successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
}

$conn->close();
?>

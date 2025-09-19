<?php
require_once __DIR__ . "/db_conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $coverImage = '';

    // Handle cover image upload if provided
    if (!empty($_FILES['cover_image']['name'])) {
        $uploadDir = "uploads/albums/covers/";
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $coverImage = $uploadDir . time() . "_" . basename($_FILES['cover_image']['name']);
        move_uploaded_file($_FILES['cover_image']['tmp_name'], $coverImage);
    }

    if ($title === '') {
        echo json_encode(["status" => "error", "message" => "Album title is required"]);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO gallery_albums (title, description, cover_image, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sss", $title, $description, $coverImage);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Album created successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed: " . $conn->error]);
    }
}
?>

<?php
// admin/add_photo_album.php

header('Content-Type: application/json');
include 'db_connect.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $cover_image = $_FILES['cover_image'] ?? null;

    if (empty($title)) {
        $response['message'] = 'Album title is required.';
        echo json_encode($response);
        exit();
    }

    // Handle cover image upload
    $uploadDir = '../uploads/albums/'; // Relative path from admin/ to uploads/albums/
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $cover_image_path = '';
    if ($cover_image && $cover_image['error'] == UPLOAD_ERR_OK) {
        $fileName = uniqid() . '_' . basename($cover_image['name']);
        $targetFilePath = $uploadDir . $fileName;
        $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        // Allow certain file formats
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($imageFileType, $allowTypes)) {
            if (move_uploaded_file($cover_image['tmp_name'], $targetFilePath)) {
                $cover_image_path = $targetFilePath;
            } else {
                $response['message'] = 'Failed to upload cover image.';
                echo json_encode($response);
                exit();
            }
        } else {
            $response['message'] = 'Sorry, only JPG, JPEG, PNG & GIF files are allowed for cover image.';
            echo json_encode($response);
            exit();
        }
    } else {
        $response['message'] = 'Cover image upload failed or no image provided.';
        echo json_encode($response);
        exit();
    }

    // Insert album data into database
    $stmt = $conn->prepare("INSERT INTO albums (title, description, cover_image_path) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $description, $cover_image_path);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Album created successfully!';
    } else {
        $response['message'] = 'Database error: ' . $stmt->error;
    }

    $stmt->close();
} else {
    $response['message'] = 'Invalid request method.';
}

$conn->close();
echo json_encode($response);
?>

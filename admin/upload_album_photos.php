<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost';
$dbname = 'ngo_site';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    echo 'Database connection failed: ' . $conn->connect_error;
    exit;
}

$albumId = $_POST['album_id'] ?? '';
if (empty($albumId)) {
    echo 'Please select an album';
    exit;
}

// Validate album exists
$stmt = $conn->prepare("SELECT id FROM gallery_albums WHERE id = ?");
$stmt->bind_param("s", $albumId);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    echo 'Selected album does not exist';
    exit;
}
$stmt->close();

// Check photos
if (!isset($_FILES['photos']) || empty($_FILES['photos']['name'][0])) {
    echo 'No photos selected';
    exit;
}

// Define new storage path
$albumDir = __DIR__ . '/uploads/photos/' . $albumId . '/';
if (!is_dir($albumDir)) mkdir($albumDir, 0755, true);

$uploadedPhotos = [];
foreach ($_FILES['photos']['tmp_name'] as $key => $tmpName) {
    if ($_FILES['photos']['error'][$key] !== UPLOAD_ERR_OK) continue;

    $fileName = basename($_FILES['photos']['name'][$key]);
    $filePath = $albumDir . $fileName;
    $relativePath = 'admin/uploads/photos/' . $albumId . '/' . $fileName; // Path for HTML/JS

    if (move_uploaded_file($tmpName, $filePath)) $uploadedPhotos[] = $relativePath;
}

// Insert into DB
if (!empty($uploadedPhotos)) {
    $placeholders = implode(',', array_fill(0, count($uploadedPhotos), '(?, ?)'));
    $types = str_repeat('ss', count($uploadedPhotos));
    $values = [];
    foreach ($uploadedPhotos as $photoPath) {
        $values[] = $albumId;
        $values[] = $photoPath;
    }

    $sql = "INSERT INTO gallery_photos (album_id, image_path) VALUES $placeholders";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo 'Prepare failed: ' . $conn->error;
        exit;
    }

    $stmt->bind_param($types, ...$values);

    if ($stmt->execute()) {
        echo 'Photos uploaded successfully to album ' . $albumId;
    } else {
        echo 'Failed to save photos: ' . $stmt->error;
    }
    $stmt->close();
} else {
    echo 'No photos uploaded';
}

$conn->close();
?>

<?php
header('Content-Type: application/json');

// 1. Connect to database
$conn = new mysqli("localhost", "root", "", "ngo_site");
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection failed."]);
    exit;
}

// 2. Get JSON input
$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['id']) || empty($data['id'])) {
    echo json_encode(["success" => false, "message" => "Missing news ID."]);
    exit;
}

$newsId = intval($data['id']);

// 3. Get the image file path first (to delete the file)
$getImageQuery = $conn->prepare("SELECT image_path FROM news WHERE id = ?");
$getImageQuery->bind_param("i", $newsId);
$getImageQuery->execute();
$getImageQuery->bind_result($imagePath);
$getImageQuery->fetch();
$getImageQuery->close();

if (!$imagePath) {
    echo json_encode(["success" => false, "message" => "News item not found."]);
    exit;
}

// 4. Delete the news item from the database
$deleteQuery = $conn->prepare("DELETE FROM news WHERE id = ?");
$deleteQuery->bind_param("i", $newsId);
$deleteQuery->execute();
$deleteQuery->close();

// 5. Delete the image file if it exists
$fullImagePath = "../" . $imagePath;
if (file_exists($fullImagePath)) {
    unlink($fullImagePath); // Delete the image
}

echo json_encode(["success" => true, "message" => "News deleted successfully."]);
$conn->close();
?>

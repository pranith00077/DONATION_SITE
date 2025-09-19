<?php
header('Content-Type: application/json');

// Database connection parameters
$host = 'localhost';
$dbname = 'ngo_site';
$username = 'root';
$password = '';

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

// Get album_id from query parameter
$album_id = $_GET['album_id'] ?? '';

if (empty($album_id)) {
    echo json_encode(['success' => false, 'message' => 'Album ID is required']);
    exit;
}

// Fetch photos for the album
$sql = "SELECT image_path FROM gallery_photos WHERE album_id = ? ORDER BY uploaded_at ASC";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
    exit;
}

$stmt->bind_param("s", $album_id);
$stmt->execute();
$result = $stmt->get_result();

$photos = [];

while ($row = $result->fetch_assoc()) {
    $photos[] = ['file' => $row['photo_path']];
}

$stmt->close();
$conn->close();

echo json_encode($photos);
?>

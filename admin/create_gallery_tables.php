<?php
require_once __DIR__ . "/db_conn.php";

header('Content-Type: application/json');

// SQL to create gallery_albums table
$sql_albums = "CREATE TABLE IF NOT EXISTS gallery_albums (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    cover_image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

// SQL to create gallery_photos table
$sql_photos = "CREATE TABLE IF NOT EXISTS gallery_photos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    album_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (album_id) REFERENCES gallery_albums(id) ON DELETE CASCADE
)";

$success = true;
$messages = [];

if ($conn->query($sql_albums) === TRUE) {
    $messages[] = "Table gallery_albums created successfully or already exists.";
} else {
    $success = false;
    $messages[] = "Error creating gallery_albums table: " . $conn->error;
}

if ($conn->query($sql_photos) === TRUE) {
    $messages[] = "Table gallery_photos created successfully or already exists.";
} else {
    $success = false;
    $messages[] = "Error creating gallery_photos table: " . $conn->error;
}

echo json_encode([
    'success' => $success,
    'messages' => $messages
]);

$conn->close();
?>

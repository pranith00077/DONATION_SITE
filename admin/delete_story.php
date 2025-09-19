<?php
header('Content-Type: application/json');

// Database connection (replace with your actual connection details)
$servername = "localhost";
$username = "root"; // Your database username
$password = "";     // Your database password
$dbname = "ngo_site"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

// Get the raw POST data
$input = file_get_contents('php://input');
$data = json_decode($input, true);

$id = isset($data['id']) ? (int)$data['id'] : 0;

if ($id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid ID provided.']);
    exit();
}

// Prepare and execute the DELETE statement for stories
$stmt = $conn->prepare("DELETE FROM stories WHERE id = ?"); // Replace 'stories' with your actual table name for stories
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Story deleted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Story not found or already deleted.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to delete story: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>

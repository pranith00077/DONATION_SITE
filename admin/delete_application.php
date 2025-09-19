<?php
// delete_application.php

// Include database connection
include 'config.php'; // Adjust the path as necessary

// Get the raw POST data
$data = json_decode(file_get_contents("php://input"), true);

// Check if ID is provided
if (isset($data['id'])) {
    $id = intval($data['id']); // Ensure it's an integer

    // Prepare the SQL statement
    $stmt = $conn->prepare("DELETE FROM applications WHERE id = ?");
    $stmt->bind_param("i", $id);

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Application deleted successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to delete application: " . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid application ID."]);
}

$conn->close();
?>


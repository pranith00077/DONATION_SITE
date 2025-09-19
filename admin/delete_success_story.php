<?php
header("Content-Type: application/json");

// Connect to MySQL
$host = "localhost"; // Use "localhost" for XAMPP or your server's address
$user = "root";
$pass = "";
$db = "ngo_site";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Connection failed"]);
    exit;
}

// Get ID from POST
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id'])) {
    echo json_encode(["success" => false, "message" => "Missing story ID"]);
    exit;
}

$id = $conn->real_escape_string($data['id']);

// Delete the story
$sql = "DELETE FROM story WHERE id = '$id'";
if ($conn->query($sql)) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Delete failed"]);
}

$conn->close();
?>

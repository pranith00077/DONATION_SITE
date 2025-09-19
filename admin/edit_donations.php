<?php
error_log("RAW INPUT: " . file_get_contents("php://input"));

header("Content-Type: application/json");

$host = "localhost"; // Use "localhost" for XAMPP or your server's address
$username = "root"; // Your database username
$password = "";
$database = "ngo_site"; // Your database name

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection failed: " . $conn->connect_error]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['id'])) {
    echo json_encode(["success" => false, "message" => "Invalid input."]);
    exit;
}

// Extract fields
$id = $data['id'];
$name = $data['name'];
$email = $data['email'];
$phone = $data['phone'];
$amount = $data['amount'];
$purpose = $data['purpose'];
$type = $data['type'];
$transaction_id = $data['transaction_id'];
$created_at = $data['created_at'];

// Prepare SQL with placeholders to prevent SQL injection
$sql = "UPDATE donations SET 
            name = ?, 
            email = ?, 
            phone = ?, 
            amount = ?, 
            purpose = ?, 
            type = ?, 
            transaction_id = ?, 
            created_at = ?
        WHERE id = ?";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
    exit;
}

$stmt->bind_param("ssssssssi", $name, $email, $phone, $amount, $purpose, $type, $transaction_id, $created_at, $id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Donation updated successfully."]);
} else {
    echo json_encode(["success" => false, "message" => "Execute failed: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>

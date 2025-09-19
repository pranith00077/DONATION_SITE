<?php
include("admin/config.php");

$data = json_decode(file_get_contents("php://input"), true);

$name     = $data["name"];
$email    = $data["email"];
$phone    = $data["phone"];
$type     = $data["type"];
$amount   = $data["amount"];
$payment_id = $data["payment_id"];

$stmt = $conn->prepare("INSERT INTO donations (name, email, phone, amount, donation_type, purpose) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssiss", $name, $email, $phone, $amount, $type, $purpose);

if ($stmt->execute()) {
  echo "Donation recorded with Payment ID: " . $payment_id;
} else {
  http_response_code(500);
  echo "Error saving donation";
}
?>

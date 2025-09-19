<?php
include("config.php");
if (!isset($_SESSION['admin'])) {
  http_response_code(403);
  echo json_encode(["error" => "Not authorized"]);
  exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];

$stmt = $conn->prepare("DELETE FROM media WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
  echo json_encode(["success" => true]);
} else {
  http_response_code(500);
  echo json_encode(["error" => "Delete failed"]);
}
?>
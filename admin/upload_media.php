<?php
include("config.php");
if (!isset($_SESSION['admin'])) {
  http_response_code(403);
  echo json_encode(["error" => "Not authorized"]);
  exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$title = $data['title'] ?? '';
$type = $data['type'] ?? '';
$link = $data['link'] ?? '';

if (!$title || !$type || !$link) {
  http_response_code(400);
  echo json_encode(["error" => "Missing fields"]);
  exit;
}

$stmt = $conn->prepare("INSERT INTO media (title, type, link) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $title, $type, $link);

if ($stmt->execute()) {
  echo json_encode(["success" => true]);
} else {
  http_response_code(500);
  echo json_encode(["error" => "Insert failed"]);
}
?>
<?php
include("config.php");
if (!isset($_SESSION['admin'])) {
  http_response_code(403);
  echo json_encode(["error" => "Not authorized"]);
  exit;
}

$result = $conn->query("SELECT * FROM media ORDER BY created_at DESC");
$media = [];
while ($row = $result->fetch_assoc()) {
  $media[] = $row;
}
header('Content-Type: application/json');
echo json_encode($media);
?>
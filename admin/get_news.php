<?php
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "ngo_site");
if ($conn->connect_error) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT id, title, content, image_path, published_at FROM news ORDER BY published_at DESC";
$result = $conn->query($sql);

$newsList = [];

function cleanImagePath($path) {
    $path = str_replace('../', '', $path); // remove ../
    if (!str_starts_with($path, 'uploads/')) {
        $path = 'uploads/news/' . $path;
    }
    return $path;
}

while ($row = $result->fetch_assoc()) {
    if (!empty($row['image_path'])) {
        $row['image_path'] = cleanImagePath($row['image_path']);
    }
    $newsList[] = $row;
}

echo json_encode($newsList);
$conn->close();
?>

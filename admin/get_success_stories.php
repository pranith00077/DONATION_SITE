<?php
header("Content-Type: application/json");

// Connect to MySQL
$host = "localhost"; // Use "localhost" for XAMPP or your server's address
$user = "root";
$pass = "";
$db = "ngo_site";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    echo json_encode([]);
    exit;
}

// Fetch all stories
$sql = "SELECT id, title FROM story ORDER BY id DESC";
$result = $conn->query($sql);

$stories = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $stories[] = $row;
    }
}

echo json_encode($stories);
$conn->close();
?>

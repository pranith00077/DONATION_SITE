<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("localhost", "root", "", "ngo_site");
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "DB connection failed"]);
    exit;
}

$title = $_POST['title'] ?? '';
$summary = $_POST['content'] ?? ''; // map 'content' to 'summary'
$imageName = '';

if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $imageTmp = $_FILES['image']['tmp_name'];
    $imageName = basename($_FILES['image']['name']);
    $targetDir = "../images/";
    if (!move_uploaded_file($imageTmp, $targetDir . $imageName)) {
        echo json_encode(["success" => false, "message" => "Image upload failed"]);
        exit;
    }
} else {
    echo json_encode(["success" => false, "message" => "Image is missing"]);
    exit;
}

$stmt = $conn->prepare("INSERT INTO story (title, summary, image) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $title, $summary, $imageName);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Success story uploaded"]);
} else {
    echo json_encode(["success" => false, "message" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>

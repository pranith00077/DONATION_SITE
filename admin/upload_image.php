<?php
header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "ngo_site";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection failed: " . $conn->connect_error]);
    exit;
}

// Check if form submitted with file
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
    $title       = $conn->real_escape_string($_POST["title"]);
    $description = $conn->real_escape_string($_POST["description"]);

    // Ensure upload folder exists
    $targetDir = __DIR__ . "/uploads/gallery/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true); // Create folder if it doesn't exist
    }

    // File details
    $fileName   = basename($_FILES["image"]["name"]);
    $fileTmp    = $_FILES["image"]["tmp_name"];
    $fileType   = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $targetFile = $targetDir . time() . "_" . preg_replace("/[^A-Za-z0-9._-]/", "_", $fileName);

    // Validate file type
    $allowedTypes = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($fileType, $allowedTypes)) {
        echo json_encode(["success" => false, "message" => "Only JPG, JPEG, PNG, and GIF files are allowed."]);
        exit;
    }

    // Move file
    if (move_uploaded_file($fileTmp, $targetFile)) {
        // Save relative path in DB (so frontend can load correctly)
        $dbPath = "uploads/gallery/" . basename($targetFile);

        $sql = "INSERT INTO gallery (title, description, image_path) VALUES ('$title', '$description', '$dbPath')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["success" => true, "message" => "Image uploaded successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Database insert error: " . $conn->error]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Failed to move uploaded file. Check folder permissions."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "No file uploaded."]);
}

$conn->close();
?>

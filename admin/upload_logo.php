<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Connect to DB
$conn = new mysqli("localhost", "root", "", "ngo_site");
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "DB connection failed"]);
    exit;
}

// Check if logo file is uploaded
if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
    $tmpName = $_FILES['logo']['tmp_name'];
    $fileName = basename($_FILES['logo']['name']);

    $uploadDir = "../images/logo/";
    $uploadPath = $uploadDir . $fileName;

    // Create folder if missing
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Move uploaded file
    if (move_uploaded_file($tmpName, $uploadPath)) {
        $relativePath = "images/logo/" . $fileName;

        // Ensure row exists
        $conn->query("INSERT INTO settings (id) VALUES (1) ON DUPLICATE KEY UPDATE id=id");

        // Update the logo path in DB
        $stmt = $conn->prepare("UPDATE settings SET logo = ?, updated_at = NOW() WHERE id = 1");
        $stmt->bind_param("s", $relativePath);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo json_encode(["success" => true, "message" => "Logo uploaded and saved to database"]);
            } else {
                echo json_encode(["success" => false, "message" => "Database row exists but update failed"]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "DB update failed: " . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Failed to move uploaded file"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "No file uploaded or error occurred"]);
}

$conn->close();
?>

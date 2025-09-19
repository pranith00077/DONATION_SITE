<?php
header('Content-Type: application/json');

// Database connection (replace with your actual database credentials)
$servername = "localhost"; // Use "localhost" for XAMPP or your server's address
$username = "root"; // Your database username
$password = "";     // Your database password
$dbname = "ngo_site"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

// Check if form data is received
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $published_at = $_POST['published_at'] ?? '';
    $image_path = null;

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../uploads/news/"; // Directory where images will be stored (relative to admin.html)
        
        // Create the directory if it doesn't exist
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Create recursively with full permissions
        }

        $file_name = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . uniqid() . "_" . $file_name; // Add unique ID to prevent overwrites
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is an actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            echo json_encode(['success' => false, 'message' => 'File is not an image.']);
            exit();
        }

        // Check file size (e.g., 5MB limit)
        if ($_FILES["image"]["size"] > 5000000) {
            echo json_encode(['success' => false, 'message' => 'Sorry, your file is too large. Max 5MB.']);
            exit();
        }

        // Allow certain file formats
        $allowed_extensions = ['jpg', 'png', 'jpeg', 'gif'];
        if (!in_array($imageFileType, $allowed_extensions)) {
            echo json_encode(['success' => false, 'message' => 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.']);
            exit();
        }

        // Try to upload file
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_path = $target_file; // Store the path to save in DB
        } else {
            echo json_encode(['success' => false, 'message' => 'Sorry, there was an error uploading your image. Error code: ' . $_FILES['image']['error']]);
            exit();
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No image uploaded or upload error: ' . ($_FILES['image']['error'] ?? 'Unknown error')]);
        exit();
    }

    // Insert data into database
    $stmt = $conn->prepare("INSERT INTO news (title, content, published_at, image_path) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $content, $published_at, $image_path);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'News article added successfully!']);
    } else {
        // If image was uploaded but DB insert failed, try to delete the uploaded image
        if ($image_path && file_exists($image_path)) {
            unlink($image_path);
        }
        echo json_encode(['success' => false, 'message' => 'Failed to add news article to database: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>

<?php
header("Content-Type: application/json");
include "db_conn.php";

try {
    $notification_id = $_POST['notification'] ?? '';
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';
    $location = $_POST['location'] ?? '';
    $studying = $_POST['studying'] ?? '';

    // Basic validation
    if (!$notification_id || !$name || !$phone || !$email || !$location || !$studying) {
        echo json_encode(["success" => false, "message" => "Please fill all fields."]);
        exit;
    }

    // Lookup notification title from publications
    $stmt = $conn->prepare("SELECT title FROM publications WHERE id = ?");
    $stmt->bind_param("i", $notification_id);
    $stmt->execute();
    $stmt->bind_result($notification_title);
    $stmt->fetch();
    $stmt->close();

    if (!$notification_title) {
        $notification_title = "Unknown Notification";
    }

    // Insert into applications table (save notification name instead of ID)
    $stmt = $conn->prepare("
        INSERT INTO applications (notification_title, name, phone, email, location, studying, at)
        VALUES (?, ?, ?, ?, ?, ?, NOW())
    ");
    $stmt->bind_param("ssssss", $notification_title, $name, $phone, $email, $location, $studying);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => $stmt->error]);
    }

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>

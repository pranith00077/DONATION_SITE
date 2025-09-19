<?php
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set("display_errors", 0);
ini_set("log_errors", 1);
ini_set("error_log", __DIR__ . "/php_error.log");

require_once __DIR__ . "/db_conn.php";

$response = ["success" => false, "message" => "Unknown error"];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $album_id = isset($_POST['album_id']) ? (int) $_POST['album_id'] : 0;

    if ($album_id > 0) {
        try {
            // Get and delete photo files
            $stmt = $conn->prepare("SELECT image_path FROM gallery_photos WHERE album_id = ?");
            if ($stmt) {
                $stmt->bind_param("i", $album_id);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    $photoPath = __DIR__ . "/uploads/" . $row['photo_path'];
                    if (file_exists($photoPath)) {
                        unlink($photoPath);
                    }
                }
                $stmt->close();
            }

            // Delete photos from DB
            $stmt = $conn->prepare("DELETE FROM gallery_photos WHERE album_id = ?");
            if ($stmt) {
                $stmt->bind_param("i", $album_id);
                $stmt->execute();
                $stmt->close();
            }

            // Delete album
            $stmt = $conn->prepare("DELETE FROM gallery_albums WHERE id = ?");
            if ($stmt) {
                $stmt->bind_param("i", $album_id);
                $stmt->execute();
                $stmt->close();
            }

            $response = ["success" => true, "message" => "Album and photos deleted successfully"];
        } catch (Exception $e) {
            $response = ["success" => false, "message" => "Exception: " . $e->getMessage()];
        }
    } else {
        $response = ["success" => false, "message" => "Invalid album ID"];
    }
} else {
    $response = ["success" => false, "message" => "Invalid request method"];
}

echo json_encode($response);
exit;

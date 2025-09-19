<?php
header("Content-Type: application/json");
require_once "db_conn.php"; // database connection

// Enable detailed error reporting (optional for debugging)
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    // Fetch all applications, newest first
    $query = "
        SELECT 
            id,
            notification_title,
            name,
            phone,
            email,
            location,
            studying,
            at AS submitted_at
        FROM applications
        ORDER BY at DESC
    ";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    $applications = [];
    while ($row = $result->fetch_assoc()) {
        $applications[] = [
            'id' => $row['id'],
            'notification_title' => $row['notification_title'] ?? 'Unknown Notification',
            'name' => $row['name'],
            'phone' => $row['phone'],
            'email' => $row['email'],
            'location' => $row['location'],
            'studying' => $row['studying'],
            'submitted_at' => $row['submitted_at']
        ];
    }

    echo json_encode($applications);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
?>

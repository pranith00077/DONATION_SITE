<?php

// Set internal character encoding to UTF-8
ini_set('default_charset', 'UTF-8');
mb_internal_encoding('UTF-8');

// Disable display of errors for security in a production environment
// In development, you might want to display errors or log them
ini_set('display_errors', 0); // Set to 1 for development, 0 for production
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php_errors.log'); // Log errors to a file (ensure this path is writable)

// Set the content type header BEFORE any output. This is crucial for AJAX.
// This header MUST be sent before any other output (even whitespace).
header("Content-Type: application/json; charset=UTF-8");

// Include the database connection file.
// Ensure db_conn.php itself has no output before its opening <?php tag.
require_once __DIR__ . "/db_conn.php";

// Check if the database connection was successful
if ($conn->connect_error) {
    // Log the connection error
    error_log("Database Connection failed: " . $conn->connect_error, 0); // 0 indicates regular message
    // Return a JSON error response and set a 500 Internal Server Error status code
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed."]);
    exit; // Stop script execution
}

// Prepare the main query using a prepared statement for safety (good practice)
$query = "SELECT id, title, description, cover_image, created_at
          FROM gallery_albums
          ORDER BY created_at DESC";

// Execute the main query
$result = $conn->query($query);

// Check if the main query execution failed
if (!$result) {
    // Log the query error
    error_log("Error executing album query: " . $conn->error, 0);
    // Return a JSON error response and set a 500 Internal Server Error status code
    http_response_code(500);
    echo json_encode(["error" => "Failed to fetch albums."]);
    exit; // Stop script execution
}

$albums = [];

// Fetch albums row by row
while ($album = $result->fetch_assoc()) {
    // Cast id to integer to ensure correct data type in JSON
    $album['id'] = (int)$album['id'];
    // Trim leading slash from cover image path
    // Ensure the path is correct for your setup. If images are at the web root,
    // and cover_image includes the leading slash, this is correct.
    $album['cover_image'] = ltrim($album['cover_image'], "/");

    // Prepare the query for photos in this album using a prepared statement
    $photosQuery = $conn->prepare("SELECT image_path FROM gallery_photos WHERE album_id = ?");

    // Check if prepared statement for photos failed
    if (!$photosQuery) {
        error_log("Error preparing photos query: " . $conn->error, 0);
        // If we can't even prepare the photo query, we can add the album but log the issue.
        $album['photos'] = []; // Add an empty photos array
        $albums[] = $album; // Add the album with empty photos
        continue; // Move to the next album
    }

    // Bind the album ID parameter to the prepared statement
    $photosQuery->bind_param("i", $album['id']);

    // Execute the photos query
    if (!$photosQuery->execute()) {
         error_log("Error executing photos query for album ID " . $album['id'] . ": " . $photosQuery->error, 0);
         // If executing the photo query fails, add the album with empty photos and log.
         $album['photos'] = []; // Add an empty photos array
         $albums[] = $album; // Add the album with empty photos
         $photosQuery->close(); // Close the statement before continuing
         continue; // Move to the next album
    }

    // Get the result set from the executed photos query
    $photosResult = $photosQuery->get_result();

    $photos = [];
    // Fetch photo paths for the current album
    while ($row = $photosResult->fetch_assoc()) {
        // Trim leading slash from photo image paths
        // Ensure the path is correct for your setup.
        $photos[] = ltrim($row['image_path'], "/");
    }

    // Free the result set for photos
    $photosResult->free(); // It's good practice to free results from prepared statements too

    // Close the prepared statement for photos
    $photosQuery->close();

    // Add the photos array to the current album
    $album['photos'] = $photos;

    // Add the processed album to the albums array
    $albums[] = $album;
}

// Free the result set from the main album query
$result->free();

// Close the database connection
$conn->close();

// Output the final albums array as JSON
// json_encode will handle necessary escaping.
echo json_encode($albums);

// It's highly recommended to OMIT the closing PHP tag ?>
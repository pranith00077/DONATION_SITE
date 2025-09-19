<?php
include 'db_conn.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
        $uploadDir = "../uploads/stories/";
        $imageName = basename($_FILES["image"]["name"]);
        $uploadPath = $uploadDir . $imageName;
        move_uploaded_file($_FILES["image"]["tmp_name"], $uploadPath);
        $imagePath = "uploads/stories/" . $imageName;

        $stmt = $conn->prepare("UPDATE stories SET title=?, description=?, image_path=? WHERE id=?");
        $stmt->bind_param("sssi", $title, $description, $imagePath, $id);
    } else {
        $stmt = $conn->prepare("UPDATE stories SET title=?, description=? WHERE id=?");
        $stmt->bind_param("ssi", $title, $description, $id);
    }

    echo $stmt->execute() ? "Story updated successfully." : "Error updating story.";
}
?>

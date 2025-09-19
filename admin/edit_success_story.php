<?php
include 'db_conn.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
        $uploadDir = "../uploads/success_stories/";
        $imageName = basename($_FILES["image"]["name"]);
        $uploadPath = $uploadDir . $imageName;
        move_uploaded_file($_FILES["image"]["tmp_name"], $uploadPath);
        $imagePath = "uploads/success_stories/" . $imageName;

        $stmt = $conn->prepare("UPDATE success_stories SET title=?, description=?, image_path=? WHERE id=?");
        $stmt->bind_param("sssi", $title, $description, $imagePath, $id);
    } else {
        $stmt = $conn->prepare("UPDATE success_stories SET title=?, description=? WHERE id=?");
        $stmt->bind_param("ssi", $title, $description, $id);
    }

    echo $stmt->execute() ? "Success story updated successfully." : "Error updating success story.";
}
?>

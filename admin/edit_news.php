<?php
include 'db_conn.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
        $uploadDir = "../uploads/news/";
        $imageName = basename($_FILES["image"]["name"]);
        $uploadPath = $uploadDir . $imageName;
        move_uploaded_file($_FILES["image"]["tmp_name"], $uploadPath);
        $imagePath = "uploads/news/" . $imageName;

        $stmt = $conn->prepare("UPDATE news SET title=?, content=?, image_path=? WHERE id=?");
        $stmt->bind_param("sssi", $title, $content, $imagePath, $id);
    } else {
        $stmt = $conn->prepare("UPDATE news SET title=?, content=? WHERE id=?");
        $stmt->bind_param("ssi", $title, $content, $id);
    }

    echo $stmt->execute() ? "News updated successfully." : "Error updating news.";
}
?>

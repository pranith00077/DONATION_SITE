<?php
include '../db_conn.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['size'] > 0) {
        $pdf_name = basename($_FILES["pdf_file"]["name"]);
        $target_pdf = "../uploads/publications/" . $pdf_name;
        move_uploaded_file($_FILES["pdf_file"]["tmp_name"], $target_pdf);
        $pdf_path = "uploads/publications/" . $pdf_name;

        $stmt = $conn->prepare("UPDATE publications SET title=?, description=?, pdf_file=? WHERE id=?");
        $stmt->bind_param("sssi", $title, $description, $pdf_path, $id);
    } else {
        $stmt = $conn->prepare("UPDATE publications SET title=?, description=? WHERE id=?");
        $stmt->bind_param("ssi", $title, $description, $id);
    }

    if ($stmt->execute()) {
        echo "Publication updated successfully.";
    } else {
        echo "Error updating publication.";
    }
}
?>

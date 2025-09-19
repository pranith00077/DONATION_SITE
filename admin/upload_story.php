<?php
$target_dir = "../uploads/";
$image = $_FILES["image"]["name"];
$target_file = $target_dir . basename($image);
move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

$conn = new mysqli("localhost", "root", "", "ngo_site");

$title = $_POST['title'];
$content = $_POST['content'];

$sql = "INSERT INTO stories (title, content, image) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $title, $content, $image);
$stmt->execute();

echo "success";
?>

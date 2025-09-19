<?php
$conn = new mysqli("localhost", "root", "", "ngo_site");
$result = $conn->query("SELECT * FROM stories ORDER BY id DESC");

while($row = $result->fetch_assoc()) {
    echo '
    <div class="program-card">
        <img src="uploads/' . $row['image'] . '" alt="Story">
        <h3>' . htmlspecialchars($row['title']) . '</h3>
        <p>' . substr(htmlspecialchars($row['content']), 0, 120) . '...</p>
        <a href="#" class="read-more">Read More</a>
    </div>';
}
?>

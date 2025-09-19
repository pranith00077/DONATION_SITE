<?php
include("admin/config.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name    = trim($_POST['name'] ?? '');
  $email   = trim($_POST['email'] ?? '');
  $phone   = trim($_POST['phone'] ?? '');
  $type    = $_POST['donation_type'] ?? 'one_time';
  $purpose = $_POST['purpose'] ?? 'General';
  $amount  = ($_POST['amount'] === 'custom') ? $_POST['custom_amount'] : $_POST['amount'];

  // Basic validation
  if (!$name || !$email || !$phone || !$amount || !is_numeric($amount)) {
    die("Missing or invalid fields. Please go back and correct your input.");
  }

  // Insert into database
  $stmt = $conn->prepare("INSERT INTO donations (name, email, phone, amount, donation_type, purpose) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("sssiss", $name, $email, $phone, $amount, $type, $purpose);

  if ($stmt->execute()) {
    echo "<h2>Thank you, $name!</h2><p>Your donation of ₹$amount has been recorded.</p><a href='index.html'>Back to Home</a>";
  } else {
    echo "<p>Error: " . $conn->error . "</p>";
  }
}
?>

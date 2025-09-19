<?php
// process_donation.php

// Database connection parameters
$servername = "localhost"; // Change if necessary
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "ngo_site"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$donation_type = $_POST['donation_type'];
$amount = $_POST['amount'] === 'custom' ? $_POST['custom_amount'] : $_POST['amount'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO donations (donation_type, amount, name, email, phone) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $donation_type, $amount, $name, $email, $phone);

// Execute the statement
if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

// Close connections
$stmt->close();
$conn->close();
?>

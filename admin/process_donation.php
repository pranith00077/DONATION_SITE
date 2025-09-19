<?php
include 'config.php'; // adjust if config.php is elsewhere

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $donation_type = $_POST['donation_type'] ?? '';
    $amount = $_POST['amount'] ?? '';
    $custom_amount = $_POST['custom_amount'] ?? '';
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $purpose = $_POST['purpose'] ?? '';

    // Determine final amount
    $final_amount = ($amount === 'custom') ? floatval($custom_amount) : floatval($amount);

    // Validate required fields
    if (empty($name) || empty($email) || empty($phone) || $final_amount <= 0) {
        die("Invalid input. Please check your form.");
    }

    // Prepare and insert into DB
    $stmt = $conn->prepare("INSERT INTO donations (donation_type, amount, name, email, phone, purpose) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sdssss", $donation_type, $final_amount, $name, $email, $phone, $purpose);

    if ($stmt->execute()) {
        echo "<script>alert('Thank you for your donation!'); window.location.href = '../donate.html';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}
?>

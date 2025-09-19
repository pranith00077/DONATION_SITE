<?php
include 'config.php';
header('Content-Type: application/json');

// Total Donors (unique emails)
$donors = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(DISTINCT email) AS total_donors FROM donations"))['total_donors'];

// Total ₹ Donated
$total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(amount) AS total_amount FROM donations"))['total_amount'];

// Most Supported Cause
$cause = mysqli_fetch_assoc(mysqli_query($conn, "SELECT purpose, COUNT(*) AS count FROM donations WHERE purpose IS NOT NULL AND purpose != '' GROUP BY purpose ORDER BY count DESC LIMIT 1"))['purpose'];

// Active Campaigns – hardcoded for now (you can link with campaign table if exists)
$active_campaigns = 7;

echo json_encode([
    'total_donors' => $donors,
    'total_amount' => $total,
    'most_supported_cause' => $cause ?? 'N/A',
    'active_campaigns' => $active_campaigns
]);
?>

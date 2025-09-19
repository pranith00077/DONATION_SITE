<?php
include 'config.php';

$from = $_GET['from'] ?? '';
$to = $_GET['to'] ?? '';
$cause = $_GET['cause'] ?? '';

$query = "SELECT * FROM donations WHERE 1=1";
if ($from) $query .= " AND created_at >= '$from'";
if ($to) $query .= " AND created_at <= '$to'";
if ($cause) $query .= " AND purpose = '$cause'";

$result = $conn->query($query);

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=donations.csv');

$output = fopen("php://output", "w");
fputcsv($output, ['ID', 'Name', 'Email', 'Phone', 'Amount', 'Purpose', 'Type', 'Txn ID', 'Date']);

while ($row = $result->fetch_assoc()) {
    fputcsv($output, [
        $row['id'],
        $row['name'],
        $row['email'],
        $row['phone'],
        $row['amount'],
        $row['purpose'],
        $row['donation_type'],
        $row['transaction_id'],
        $row['created_at']
    ]);
}
fclose($output);
?>

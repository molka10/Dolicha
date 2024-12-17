<?php
// Include your database connection
require_once 'C:\xampp\htdocs\dolicha0.2\config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form values
    $coupon_code = trim($_POST['coupon_code']);
    $discount = trim($_POST['discount']);
    $expiry_date = trim($_POST['expiry_date']);
    $status = trim($_POST['status']);

    // Validate the inputs (for security and data integrity)
    if (empty($coupon_code) || empty($discount) || empty($expiry_date) || empty($status)) {
        echo "All fields are required!";
        exit;
    }

    // Prepare SQL statement to insert coupon into the database
    $stmt = $pdo->prepare("INSERT INTO coupon (code, discount, expiryDate, status) VALUES (?, ?, ?, ?)");

    // Execute the statement with the form data
    $stmt->execute([$coupon_code, $discount, $expiry_date, $status]);

    // Redirect to a success page or show a success message
    echo "Coupon added successfully!";
    header('Location: index.php'); // Redirect to a success page (optional)
    exit;
}
?>

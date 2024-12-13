<?php
// Include your database configuration
require_once 'C:\xampp\htdocs\dolicha0.2\config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $couponCode = $_POST['coupon_code']; // Get the coupon code from the form

    try {
        // Prepare the query using the correct column name 'code'
        $stmt = $pdo->prepare("SELECT discount, expiryDate FROM coupon WHERE code = :coupon_code");
        $stmt->execute(['coupon_code' => $couponCode]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            // Extract expiryDate and discount from the result
            $expiryDate = $result['expiryDate'];
            $currentDate = date('Y-m-d'); // Get today's date in YYYY-MM-DD format

            if ($expiryDate < $currentDate) {
                // Coupon has expired
                echo json_encode(['success' => false, 'message' => 'Coupon has expired.']);
            } else {
                // Coupon is valid
                $discount = $result['discount'];
                echo json_encode(['success' => true, 'discount' => $discount]);
            }
        } else {
            // Coupon not found
            echo json_encode(['success' => false, 'message' => 'Invalid coupon code.']);
        }
    } catch (PDOException $e) {
        // Handle any errors
        echo json_encode(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
    }
}
?>

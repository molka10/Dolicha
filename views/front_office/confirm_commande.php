<?php
session_start();
require_once 'C:\xampp\htdocs\dolicha0.2\config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect POST data
    $orderId = $_POST['order_id'];  // Order ID
    $amount = $_POST['amount'];     // Total Amount
    $cardNumber = $_POST['card_number']; // Card Number
    $expiryDate = $_POST['expiry_date']; // Expiry Date
    $cvv = $_POST['cvv'];            // CVV
    $cardHolderName = $_POST['card_holder']; // Card Holder Name


    // Assuming the user ID and panier ID are available
    $iduser = 1; // This should be the actual user ID from your session or database
    $idpanier = $orderId; // Use the provided order ID (or you can retrieve it as needed)

    // Check if all fields are filled
    if (empty($orderId) || empty($amount) || empty($cardNumber) || empty($expiryDate) || empty($cvv) || empty($cardHolderName)) {
        echo "All fields are required.";
        exit();
    }

    try {
        // Prepare the SQL to insert the payment information into the 'commande' table
        $stmt = $pdo->prepare("INSERT INTO commande (iduser, idpanier, date, status, nom_client, total, card_number, expiry_date, cvv)
                               VALUES (:iduser, :idpanier, NOW(), 1, :nom_client, :total, :card_number, :expiry_date, :cvv)");

        // Bind parameters
        $stmt->bindParam(':iduser', $iduser);
        $stmt->bindParam(':idpanier', $idpanier);
        $stmt->bindParam(':nom_client', $cardHolderName); // Client name (card holder name)
        $stmt->bindParam(':total', $amount); // Total amount
        $stmt->bindParam(':card_number', $cardNumber); // Card number
        $stmt->bindParam(':expiry_date', $expiryDate); // Expiry date
        $stmt->bindParam(':cvv', $cvv); // CVV

        // Execute the query
        $stmt->execute();

        // If the payment information is successfully inserted
        echo "Payment Successful. Your order has been processed.";
        // Redirect to a success page or back to a confirmation page
        header('Location: success.php');
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method.";
}
?>

<?php
session_start();
require_once 'C:\xampp\htdocs\dolicha0.2\config.php';

// Retrieve POST data
$productId = filter_input(INPUT_POST, 'productId', FILTER_SANITIZE_NUMBER_INT);
$requestedQuantity = filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_NUMBER_INT);

$response = []; // Initialize response array

if ($productId && $requestedQuantity) {
    // Fetch the product to check its current quantity
    $stmt = $pdo->prepare("SELECT quantity FROM produit WHERE Idproduit = :id");
    $stmt->execute(['id' => $productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        $availableQuantity = $product['quantity'];

        if ($requestedQuantity <= $availableQuantity) {
            // Update the product quantity in the database
            $newQuantity = $availableQuantity - $requestedQuantity;
            $updateStmt = $pdo->prepare("UPDATE produit SET quantity = :quantity WHERE Idproduit = :id");
            $updateStmt->execute(['quantity' => $newQuantity, 'id' => $productId]);

            // Initialize the cart if it doesn't exist
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            // Add/update the product in the cart
            if (isset($_SESSION['cart'][$productId])) {
                $_SESSION['cart'][$productId] += $requestedQuantity; // Update quantity in the cart
            } else {
                $_SESSION['cart'][$productId] = $requestedQuantity; // Add new product to cart
            }

            $response['status'] = 'success';
            $response['message'] = 'Product added to cart successfully!';
        } else {
            $response['status'] = 'error';
            $response['message'] = "Insufficient stock available. Only $availableQuantity items are in stock.";
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = "Product not found.";
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid data.';
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>

<?php
session_start();
require_once 'C:\xampp\htdocs\dolicha0.2\config.php';
require_once 'C:\xampp\htdocs\dolicha0.2\controllers\ProductController.php';

// Initialize the controller
$productController = new ProductController($pdo);

// Retrieve POST data
$productId = filter_input(INPUT_POST, 'productId', FILTER_SANITIZE_NUMBER_INT);
$requestedQuantity = filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_NUMBER_INT);

if ($productId && $requestedQuantity) {
    // Fetch the product using the controller function
    $product = $productController->getProductById($productId);

    if ($product) {
        $availableStock = $product->getStock(); // Use object method to get stock

        if ($requestedQuantity <= $availableStock) {
            // Update the product stock in the database
            $newStock = $availableStock - $requestedQuantity;
            $stmt = $pdo->prepare("UPDATE product SET Stock = :stock WHERE ID_Product = :id");
            $stmt->execute(['stock' => $newStock, 'id' => $productId]);

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

            // Set success message
            $_SESSION['message'] = 'Product added to cart successfully!';
        } else {
            // Set error message
            $_SESSION['message'] = "Insufficient stock available. Only $availableStock items are in stock.";
        }
    } else {
        // Set error message
        $_SESSION['message'] = "Product not found.";
    }
} else {
    // Set error message
    $_SESSION['message'] = 'Invalid data.';
}

// Redirect back to indexp.php
header('Location: indexp.php');
exit;
?>

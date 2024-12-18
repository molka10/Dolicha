<?php
session_start();
require_once 'C:\xampp\htdocs\dolicha0.2\controllers\productController.php'; 
require_once 'C:\xampp\htdocs\dolicha0.2\controllers\cartController.php';
require_once 'C:\xampp\htdocs\dolicha0.2\config.php';

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $Iduser = 1; // Replace with the actual user ID
    $cartController = new PanierController($pdo);
    
    // Calculate the total price of the cart
    $total = 0;
    foreach ($_SESSION['cart'] as $Idproduit => $quantity) {
        $product = (new ProductController($pdo))->getProductById($Idproduit);
        if ($product !== null) {
            $total += $product->getPrice() * $quantity; // Total price calculation
        }
    }

    // Check if the user already has an existing cart
    $existingCartId = $cartController->getExistingCartId($Iduser);

    if ($existingCartId) {
        // If a cart exists, update it (optional)
        $cartController->updateCart($existingCartId, $total); // Update the cart total price if needed
        $panierId = $existingCartId;
    } else {
        // If no cart exists, create a new cart
        $panierId = $cartController->createPanier($Iduser, $total, 1); // 1 means the cart is confirmed 
    }

    // Add products to the 'panier_items' table
    foreach ($_SESSION['cart'] as $Idproduit => $quantity) {
        // Ensure product exists before adding it
        $product = (new ProductController($pdo))->getProductById($Idproduit);
        if ($product !== null) {
            $cartController->addProductToCart($panierId, $Idproduit, $quantity);
        }
    }

    // Clear the session cart after saving it to the database
    unset($_SESSION['cart']);
    header('Location: confirm.php'); // Redirect to the confirmation page
    exit();
} else {
    echo "Le panier est vide.";
}
?>

<?php
session_start();
require_once 'C:\xampp\htdocs\dolicha0.2\controller\productController.php';  // Include ProductController
require_once 'C:\xampp\htdocs\dolicha0.2\controller\cartController.php';
require_once 'C:\xampp\htdocs\dolicha0.2\config.php';

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $Iduser = 1; // Replace with the actual user ID (e.g., from the session or login)
    $cartController = new PanierController($pdo);

    // Calculate the total price of the cart
    $total = 0;
    foreach ($_SESSION['cart'] as $Idproduit => $quantity) {
        // Get the product details to calculate the total price
        $product = (new ProductController($pdo))->getProductById($Idproduit);
        $total += $product->getPrix() * $quantity; // Multiply product price by quantity
    }

    // Check if the user already has an existing cart
    $existingCartId = $cartController->getExistingCartId($Iduser);

    /*if ($existingCartId) {
        // If a cart exists, update the quantities of products in the cart
        foreach ($_SESSION['cart'] as $Idproduit => $quantity) {
            // Update the quantity of each product in the existing cart
            $cartController->updateProductQuantity($existingCartId, $Idproduit, $quantity);
        }
    }*/ //else {
        // If no cart exists, create a new cart
        // Insert new cart into the 'panier' table
        $panierId = $cartController->createPanier($Iduser, $total, 0); // 0 means the cart is not confirmed yet

        // Add products to the 'panier_items' table (saving `idproduit` and `quantity`)
        foreach ($_SESSION['cart'] as $Idproduit => $quantity) {
            // Add product to panier_items table
            $cartController->addProductToCart($panierId, $Idproduit, $quantity);
        }
    //}

    // Clear the session cart after saving it to the database
    unset($_SESSION['cart']);
    
    header('Location: insurance.php');
    exit();
} else {
    echo "Le panier est vide.";
}
?>

<?php
session_start();
require_once 'C:\xampp\htdocs\dolicha0.2\controller\productController.php'; 
require_once 'C:\xampp\htdocs\dolicha0.2\controller\cartController.php';
require_once 'C:\xampp\htdocs\dolicha0.2\config.php';

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $Iduser = 1; // Replace with the actual user ID
    $cartController = new PanierController($pdo);
    // Get the client's name from the form
    $nom_client = $_POST['nom_client'];
    
    // Calculate the total price of the cart
    $total = 0;
    foreach ($_SESSION['cart'] as $Idproduit => $quantity) {
        $product = (new ProductController($pdo))->getProductById($Idproduit);
        $total += $product->getPrix() * $quantity; // Total price calculation
    }

    // Check if the user already has an existing cart
    $existingCartId = $cartController->getExistingCartId($Iduser);

    // If no cart exists, create a new cart
    $panierId = $cartController->createPanier($Iduser, $total, 1); // 1 means the cart is not confirmed yet

    // Add products to the 'panier_items' table
    foreach ($_SESSION['cart'] as $Idproduit => $quantity) {
        $cartController->addProductToCart($panierId, $Idproduit, $quantity);
    }

    // Insert the order into the 'commande' table
    $orderSuccess = $cartController->insertOrder($Iduser, $panierId, $nom_client, 1); // 1 for pending status

    if ($orderSuccess) {
        // Clear the session cart after saving it to the database
        unset($_SESSION['cart']);
        header('Location: insurance.php'); // Redirect to the insurance page
        exit();
    } else {
        echo "Error placing the order.";
    }
} else {
    echo "Le panier est vide.";
}
?>
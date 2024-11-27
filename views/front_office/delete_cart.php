<?php
// Include necessary files
require_once 'C:\xampp\htdocs\dolicha0.2\controller\cartController.php';
require_once 'C:\xampp\htdocs\dolicha0.2\config.php';

// Create a new PDO instance
try {
    $pdo = new PDO('mysql:host=localhost;dbname=dolicha0.2', 'root', ''); // Adjust these values
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit; // Stop execution if the connection fails
}

// Create a new CartController object
$cartController = new PanierController($pdo);

// Check if the cart ID is set in the URL
if (isset($_GET['id'])) {
    $Idpanier = $_GET['id'];

    // Attempt to delete the cart
    if ($cartController->deletePanier($Idpanier)) {
        echo "Cart deleted successfully!";
        // Redirect to the cart management page
        header("Location: affichepanier.php");
        exit;
    } else {
        echo "Failed to delete cart. It may not exist.";
    }
} else {
    echo "No cart ID provided!";
    exit;
}
?>
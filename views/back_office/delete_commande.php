<?php
// Include necessary files
require_once 'C:\xampp\htdocs\dolicha0.2\controller\ComandeController.php';
require_once 'C:\xampp\htdocs\dolicha0.2\config.php';

try {
    // Create a new PDO instance
    $pdo = new PDO('mysql:host=localhost;dbname=dolicha0.2', 'root', ''); // Adjust these values
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create a new CommandeController object
    $commandeController = new CommandeController($pdo);

    // Check if the id is set
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        
        // Call the method to delete the order
        $commandeController->deleteCommande($id); // Ensure this method exists in your CommandeController

        // Redirect to the orders page after deletion
        header("Location: index.php?message=Order+deleted+successfully");
        exit;
    } else {
        echo "No order ID specified.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
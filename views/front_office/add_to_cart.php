<?php
session_start();
require_once 'C:\xampp\htdocs\dolicha0.2\config.php';

// Retrieve POST data
$productId = filter_input(INPUT_POST, 'productId', FILTER_SANITIZE_NUMBER_INT);
$quantity = filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_NUMBER_INT);

if ($productId && $quantity) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] += $quantity;
    } else {
        $_SESSION['cart'][$productId] = $quantity;
    }

    // Redirect to the cart page
    header('Location: view_cart.php');
    exit();
} else {
    echo 'Invalid data.';
}
?>

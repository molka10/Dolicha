<?php
session_start();

// Vérifier si l'ID du produit est passé en POST
$productId = filter_input(INPUT_POST, 'productId', FILTER_SANITIZE_NUMBER_INT);

if ($productId !== null && isset($_SESSION['cart'][$productId])) {
    // Réduire la quantité du produit
    if ($_SESSION['cart'][$productId] > 1) {
        $_SESSION['cart'][$productId]--; // Décrémenter la quantité
        echo "Quantité réduite avec succès.";
    } else {
        // Si la quantité est 1, supprimer le produit
        unset($_SESSION['cart'][$productId]);
        echo "Produit supprimé avec succès.";
    }
} else {
    echo "Produit introuvable dans le panier.";
}

// Rediriger vers la page du panier
header('Location: view_cart.php');
exit();
?>

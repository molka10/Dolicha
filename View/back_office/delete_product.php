<?php

include 'C:\xampp\htdocs\produit\dolicha\config.php';
include 'C:\xampp\htdocs\produit\dolicha\controllers\ProductController.php';

$productController = new ProductController($pdo);
$id = $_GET['id'];

if (!isset($id)) {
    die("Error: ID parameter not set.");
}

$product = $productController->getProduct($id);

if (!$product) {
    die("Error: Product not found.");
}


$imagePath = $product->getImage(); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if ($imagePath && file_exists($imagePath)) {
        unlink($imagePath); 
    }

    
    $productController->deleteProduct($id);

    
    header("Location: index_product.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Product</title>
</head>
<body>
    <h1>Delete Product</h1>
    <p>Are you sure you want to delete the product "<?= htmlspecialchars($product->getName()) ?>"?</p>
    <form method="post">
        <button type="submit">Yes, Delete</button>
        <a href="index_product.php">Cancel</a>
    </form>
</body>
</html>

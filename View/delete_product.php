<?php
include '../db.php';
include '../controllers/ProductController.php';

$productController = new ProductController($pdo);
$id = $_GET['id'];

if (!isset($id)) {
    die("Error: ID parameter not set.");
}

$product = $productController->getProduct($id);

if (!$product) {
    die("Error: Product not found.");
}

// Check if there is an image to delete
$imagePath = $product->getImage(); // Assuming 'getImage()' returns the file path of the product image

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Delete the product image file if it exists
    if ($imagePath && file_exists($imagePath)) {
        unlink($imagePath); // Delete the image file from the server
    }

    // Delete the product from the database
    $productController->deleteProduct($id);

    // Redirect to the main product listing page
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

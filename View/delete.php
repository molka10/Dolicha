<?php
include '../db.php';
include '../controllers/CategoryController.php';

$controller = new CategoryController($pdo);

// Validate the 'id' parameter
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Fetch the category to ensure it exists before deletion
    $category = $controller->getCategory($id);

    if ($category) {
        // If the category exists, delete it
        $controller->deleteCategory($id);
        // Redirect after deletion
        header("Location: index.php");
        exit;
    } else {
        // Category not found
        echo "Category not found.";
        exit;
    }
} else {
    echo "Invalid or missing ID.";
    exit;
}
?>

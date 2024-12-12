<?php
include '../db.php';
include '../controllers/CategoryController.php';

$controller = new CategoryController($pdo);


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];

    
    $category = $controller->getCategory($id);

    if ($category) {
        
        $controller->deleteCategory($id);
        
        header("Location: index.php");
        exit;
    } else {
        
        echo "Category not found.";
        exit;
    }
} else {
    echo "Invalid or missing ID.";
    exit;
}
?>

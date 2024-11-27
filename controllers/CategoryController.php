<?php
include 'C:\xampp\htdocs\produit\dolicha\db.php';
include 'C:\xampp\htdocs\produit\dolicha\models\Category.php';

class CategoryController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Create a new category
    public function createCategory($categoryName) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO category (CategoryName) VALUES (:categoryName)");
            $stmt->execute(['categoryName' => $categoryName]);
            return new Category($this->pdo->lastInsertId(), $categoryName);
        } catch (PDOException $e) {
            echo "Error creating category: " . $e->getMessage();
            return null;
        }
    }

    // Get a specific category by ID
    public function getCategory($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM category WHERE ID_Category = :id");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if category was found
        if ($data) {
            return new Category($data['ID_Category'], $data['CategoryName']);
        } else {
            return null;  // Return null if category is not found
        }
    }

    // Get all categories
    public function getAllCategories() {
        $stmt = $this->pdo->query("SELECT * FROM category");
        $categories = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categories[] = new Category($row['ID_Category'], $row['CategoryName']);
        }
        return $categories;
    }

    public function updateCategory($id, $categoryName)
{
    // Use 'category' instead of 'categories' to match the table name in your database
    $stmt = $this->pdo->prepare("UPDATE category SET CategoryName = :categoryName WHERE ID_Category = :id");

    // Bind parameters
    $stmt->bindParam(':categoryName', $categoryName);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Execute query
    if ($stmt->execute()) {
        return true;  // Category updated successfully
    } else {
        return false; // Error occurred
    }
}


    // Delete a category
    public function deleteCategory($id) {
        try {
            // Delete all products associated with this category
            $stmt = $this->pdo->prepare("DELETE FROM product WHERE ID_Category = :id");
            $stmt->execute(['id' => $id]);

            // Then delete the category itself
            $stmt = $this->pdo->prepare("DELETE FROM category WHERE ID_Category = :id");
            $stmt->execute(['id' => $id]);

            return true;  // Return true if both deletions were successful
        } catch (PDOException $e) {
            echo "Error deleting category: " . $e->getMessage();
            return false;  // Return false in case of an error
        }
    }
}
?>

<?php
include '../db.php';
include '../models/Product.php';

class ProductController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Create Product
    public function createProduct($name, $price, $stock, $idCategory) {
        // Log input data
        error_log("Creating product: Name = $name, Price = $price, Stock = $stock, Category = $idCategory");
    
        // Prepare the SQL statement
        $stmt = $this->pdo->prepare("INSERT INTO product (Name, Price, Stock, ID_Category) VALUES (:name, :price, :stock, :idCategory)");
        $stmt->execute([
            'name' => $name,
            'price' => $price,
            'stock' => $stock,
            'idCategory' => $idCategory
        ]);
        // Return the product object
        return new Product($this->pdo->lastInsertId(), $name, $price, $stock, $idCategory);
    }
    

    // Get Product by ID
    public function getProduct($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM product WHERE ID_Product = :id");
            $stmt->execute(['id' => $id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($data) {
                return new Product($data['ID_Product'], $data['Name'], $data['Price'], $data['Stock'], $data['ID_Category']);
            }
            
            return null; // Return null if no product is found
        } catch (PDOException $e) {
            // Log or handle exception
            error_log("Error fetching product: " . $e->getMessage());
            return null;
        }
    }

    // Get All Products
    public function getAllProducts() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM product");
            $products = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $products[] = new Product($row['ID_Product'], $row['Name'], $row['Price'], $row['Stock'], $row['ID_Category']);
            }
            return $products;
        } catch (PDOException $e) {
            // Log or handle exception
            error_log("Error fetching all products: " . $e->getMessage());
            return [];
        }
    }

    // Update Product
    public function updateProduct($id, $name, $price, $stock, $idCategory) {
        try {
            $stmt = $this->pdo->prepare("UPDATE product SET Name = :name, Price = :price, Stock = :stock, ID_Category = :idCategory WHERE ID_Product = :id");
            $stmt->execute(['name' => $name, 'price' => $price, 'stock' => $stock, 'idCategory' => $idCategory, 'id' => $id]);
        } catch (PDOException $e) {
            // Log or handle exception
            error_log("Error updating product: " . $e->getMessage());
        }
    }

    // Delete Product
    public function deleteProduct($id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM product WHERE ID_Product = :id");
            $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            // Log or handle exception
            error_log("Error deleting product: " . $e->getMessage());
        }
    }
    // Add this method to your ProductController class
public function getCategoryNameById($categoryId) {
    try {
        $stmt = $this->pdo->prepare("SELECT CategoryName FROM category WHERE ID_Category = :id");
        $stmt->execute(['id' => $categoryId]);
        $category = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $category ? $category['CategoryName'] : null; // Return category name or null if not found
    } catch (PDOException $e) {
        // Log or handle exception
        error_log("Error fetching category name: " . $e->getMessage());
        return null;
    }
}

}
?>

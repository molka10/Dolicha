<?php
require_once 'C:\xampp\htdocs\dolicha0.2\config.php';
require_once 'C:\xampp\htdocs\dolicha0.2\models\Category.php';

class CategoryController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

   
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
    public function getCategory($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM category WHERE ID_Category = :id");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        
        if ($data) {
            return new Category($data['ID_Category'], $data['CategoryName']);
        } else {
            return null; 
        }
    }

    
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
    
    $stmt = $this->pdo->prepare("UPDATE category SET CategoryName = :categoryName WHERE ID_Category = :id");

    
    $stmt->bindParam(':categoryName', $categoryName);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    
    if ($stmt->execute()) {
        return true;  
    } else {
        return false; 
    }
}


    public function deleteCategory($id) {
        try {
            
            $stmt = $this->pdo->prepare("DELETE FROM product WHERE ID_Category = :id");
            $stmt->execute(['id' => $id]);

            
            $stmt = $this->pdo->prepare("DELETE FROM category WHERE ID_Category = :id");
            $stmt->execute(['id' => $id]);

            return true;  
        } catch (PDOException $e) {
            echo "Error deleting category: " . $e->getMessage();
            return false;  
        }
    }
    public function getCategoryById($categoryId) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM category WHERE ID_Category = :categoryId");
            $stmt->execute(['categoryId' => $categoryId]);
            $category = $stmt->fetch(PDO::FETCH_ASSOC);

            return $category ?: null;
        } catch (PDOException $e) {
            error_log("Error fetching category: " . $e->getMessage());
            return null;
        }
    }
    public function getStockDistributionByCategory() {
        try {
            $sql = "
                SELECT c.CategoryName, SUM(p.Stock) AS TotalStock
                FROM category c
                JOIN product p ON c.ID_Category = p.ID_Category
                GROUP BY c.CategoryName
            ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching stock distribution: " . $e->getMessage());
            return [];
        }
    }
    public function getProductDistributionByCategory() {
        try {
            $sql = "
                SELECT c.CategoryName, COUNT(p.ID_Product) AS ProductCount
                FROM category c
                LEFT JOIN product p ON c.ID_Category = p.ID_Category
                GROUP BY c.CategoryName
            ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching product distribution: " . $e->getMessage());
            return [];
        }
    }
    
    public function getSalesDistributionByCategory() {
        try {
            $sql = "
                SELECT c.CategoryName, SUM(p.price * p.stock) AS TotalRevenue
                FROM category c
                JOIN product p ON c.ID_Category = p.ID_Category
                GROUP BY c.CategoryName
            ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching sales distribution: " . $e->getMessage());
            return [];
        }
    }
    
}

?>

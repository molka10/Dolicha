<?php
include '../db.php';
include '../models/Product.php';

class ProductController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    
    public function createProduct($name, $price, $stock, $idCategory, $image) {
       
        error_log("Creating product: Name = $name, Price = $price, Stock = $stock, Category = $idCategory, Image = $image");
    
        
        $stmt = $this->pdo->prepare("INSERT INTO product (Name, Price, Stock, ID_Category, Image) VALUES (:name, :price, :stock, :idCategory, :image)");
        $stmt->execute([
            'name' => $name,
            'price' => $price,
            'stock' => $stock,
            'idCategory' => $idCategory,
            'image' => $image
        ]);
        
        return new Product($this->pdo->lastInsertId(), $name, $price, $stock, $idCategory, $image);
    }

    
    public function getProduct($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM product WHERE ID_Product = :id");
            $stmt->execute(['id' => $id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($data) {
                return new Product($data['ID_Product'], $data['Name'], $data['Price'], $data['Stock'], $data['ID_Category'], $data['image']);
            }
            
            return null; 
        } catch (PDOException $e) {
            
            error_log("Error fetching product: " . $e->getMessage());
            return null;
        }
    }

    
    public function getAllProducts($sortBy = null) {
        try {
            
            $query = "SELECT * FROM product";

            
            if ($sortBy === 'LastEdited') {
                $query .= " ORDER BY last_edited DESC"; 
            } elseif ($sortBy === 'Stock') {
                $query .= " ORDER BY Stock DESC";
            } elseif ($sortBy === 'Price') {
                $query .= " ORDER BY Price ASC";
            }

            
            $stmt = $this->pdo->query($query);
            $products = [];

            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $products[] = new Product(
                    $row['ID_Product'],
                    $row['Name'],
                    $row['Price'],
                    $row['Stock'],
                    $row['ID_Category'],
                    $row['image']
                );
            }

            return $products; 
        } catch (PDOException $e) {
            error_log("Error fetching products: " . $e->getMessage());
            return []; 
        }
    }


   // updateProduct
    public function updateProduct($id, $name, $price, $stock, $idCategory, $image) {
        try {
            $stmt = $this->pdo->prepare("UPDATE product SET Name = :name, Price = :price, Stock = :stock, ID_Category = :idCategory, Image = :image WHERE ID_Product = :id");
            $stmt->execute([
                'name' => $name, 
                'price' => $price, 
                'stock' => $stock, 
                'idCategory' => $idCategory, 
                'image' => $image, 
                'id' => $id
            ]);
        } catch (PDOException $e) {
            error_log("Error updating product: " . $e->getMessage());
        }
    }
    
   
    public function deleteProduct($id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM product WHERE ID_Product = :id");
            $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            
            error_log("Error deleting product: " . $e->getMessage());
        }
    }

    
    public function getCategoryNameById($categoryId) {
        try {
            $stmt = $this->pdo->prepare("SELECT CategoryName FROM category WHERE ID_Category = :id");
            $stmt->execute(['id' => $categoryId]);
            $category = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $category ? $category['CategoryName'] : null; 
        } catch (PDOException $e) {
            
            error_log("Error fetching category name: " . $e->getMessage());
            return null;
        }
    }
    public function getTopSellingProductsByStock() {
        try {
            $query = "
                SELECT p.Name AS productName, p.Stock AS stockLevel
                FROM product p
                ORDER BY p.Stock DESC
                LIMIT 10;
            ";
            
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;  // Return top-selling products with their stock levels
        } catch (PDOException $e) {
            error_log("Error fetching top-selling products: " . $e->getMessage());
            return []; // Return an empty array in case of error
        }
    }
    public function getPriceDistributionForCategories($categoryIds) {
        try {
            $placeholders = implode(',', array_fill(0, count($categoryIds), '?')); // Create placeholders for prepared statement
            $query = "
                SELECT c.CategoryName, 
                       MIN(p.Price) AS minPrice, 
                       MAX(p.Price) AS maxPrice, 
                       AVG(p.Price) AS avgPrice
                FROM category c
                JOIN product p ON c.ID_Category = p.ID_Category
                WHERE c.ID_Category IN ($placeholders)
                GROUP BY c.CategoryName;
            ";
            
            // Prepare and execute the query
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($categoryIds);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;  // Return the result as an associative array
        } catch (PDOException $e) {
            error_log("Error fetching price distribution: " . $e->getMessage());
            return []; // Return an empty array in case of error
        }
    }

    
    
}
?>

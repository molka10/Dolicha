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

    
    /*public function getAllProducts($sortOption = 'name') {
    try {
        // Define the SQL ORDER BY clause based on the sort option
        $orderByClause = 'ORDER BY Name'; // Default sorting by product name

        if ($sortOption == 'price') {
            $orderByClause = 'ORDER BY Price';
        } elseif ($sortOption == 'stock') {
            $orderByClause = 'ORDER BY Stock';
        } elseif ($sortOption == 'last_edited') {
            $orderByClause = 'ORDER BY LastEdited DESC'; // Assuming you have a LastEdited column
        }

        // Fetch products with sorting applied
        $stmt = $this->pdo->query("SELECT * FROM product $orderByClause");
        $products = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $products[] = new Product(
                $row['ID_Product'],
                $row['Name'],
                $row['Price'],
                $row['Stock'],
                $row['ID_Category'],
                $row['Image']
            );
        }

        return $products;
    } catch (PDOException $e) {
        error_log("Error fetching all products: " . $e->getMessage());
        return [];
    }
}*/

    
}
?>

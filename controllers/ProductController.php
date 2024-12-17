<?php
include '../db.php';
include '../models/Product.php';

class ProductController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    
    public function createProduct($name, $price, $stock, $idCategory, $image) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO product (Name, Price, Stock, ID_Category, Image) VALUES (:name, :price, :stock, :idCategory, :image)");
            $stmt->execute([
                'name' => $name,
                'price' => $price,
                'stock' => $stock,
                'idCategory' => $idCategory,
                'image' => $image
            ]);
            return new Product($this->pdo->lastInsertId(), $name, $price, $stock, $idCategory, $image);
        } catch (PDOException $e) {
            error_log("Error creating product: " . $e->getMessage());
            return null;
        }
    }

    
    public function getProduct($id) {
        try {
           
            $stmt = $this->pdo->prepare("SELECT ID_Product, Name, Price, Stock, ID_Category, Image FROM product WHERE ID_Product = :id");
            $stmt->execute(['id' => $id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($data) {
                
                return new Product(
                    $data['ID_Product'],
                    $data['Name'],
                    $data['Price'],
                    $data['Stock'],
                    $data['ID_Category'],
                    $data['Image'] ?? null  
                );
            }
            return null;
        } catch (PDOException $e) {
            error_log("Error fetching product: " . $e->getMessage());
            return null;
        }
    }

    
    public function getAllProducts($sortBy = null) {
        try {
            $query = "SELECT ID_Product, Name, Price, Stock, ID_Category, Image FROM product";
            if ($sortBy === 'LastEdited') {
                $query .= " ORDER BY updated_at DESC";
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
                    $row['Image'] ?? null
                );
            }
            return $products;
        } catch (PDOException $e) {
            error_log("Error fetching all products: " . $e->getMessage());
            return [];
        }
    }

    
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
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result ? $result['CategoryName'] : null;
        } catch (PDOException $e) {
            error_log("Error fetching category name: " . $e->getMessage());
            return null;
        }
    }

   
    public function getTopSellingProductsByStock() {
        try {
            $stmt = $this->pdo->query("SELECT Name AS productName, Stock AS stockLevel FROM product ORDER BY Stock DESC LIMIT 10");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching top-selling products: " . $e->getMessage());
            return [];
        }
    }

    
    public function getPriceDistributionForCategories($categoryIds) {
        try {
            $placeholders = implode(',', array_fill(0, count($categoryIds), '?'));
            $query = "SELECT c.CategoryName, MIN(p.Price) AS minPrice, MAX(p.Price) AS maxPrice, AVG(p.Price) AS avgPrice
                      FROM category c
                      JOIN product p ON c.ID_Category = p.ID_Category
                      WHERE c.ID_Category IN ($placeholders)
                      GROUP BY c.CategoryName";

            $stmt = $this->pdo->prepare($query);
            $stmt->execute($categoryIds);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching price distribution: " . $e->getMessage());
            return [];
        }
    }

    
    public function searchProducts($keyword, $sortBy = null) {
        try {
            $query = "SELECT ID_Product, Name, Price, Stock, ID_Category, Image FROM product WHERE Name LIKE :keyword";

            
            if ($sortBy === 'Price') {
                $query .= " ORDER BY Price ASC";
            } elseif ($sortBy === 'Stock') {
                $query .= " ORDER BY Stock DESC";
            } elseif ($sortBy === 'LastEdited') {
                $query .= " ORDER BY updated_at DESC";
            }

            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['keyword' => "%$keyword%"]);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $products = [];
            foreach ($results as $row) {
                $products[] = new Product(
                    $row['ID_Product'],
                    $row['Name'],
                    $row['Price'],
                    $row['Stock'],
                    $row['ID_Category'],
                    $row['Image'] ?? null 
                );
            }
            return $products;
        } catch (PDOException $e) {
            error_log("Error searching products: " . $e->getMessage());
            return [];
        }
    }
    public function advancedSearch($categoryId = '', $priceMin = '', $priceMax = '') {
        
        $categoryId = htmlspecialchars($categoryId);
        $priceMin = htmlspecialchars($priceMin);
        $priceMax = htmlspecialchars($priceMax);

        
        $filters = [];
        if ($categoryId) {
            $filters[] = "category_id = :categoryId";
        }
        if ($priceMin) {
            $filters[] = "price >= :priceMin";
        }
        if ($priceMax) {
            $filters[] = "price <= :priceMax";
        }

        
        $whereClause = '';
        if (count($filters) > 0) {
            $whereClause = "WHERE " . implode(" AND ", $filters);
        }

        
        $sql = "SELECT * FROM products " . $whereClause;
        $stmt = $this->pdo->prepare($sql);

        
        if ($categoryId) {
            $stmt->bindValue(':categoryId', $categoryId);
        }
        if ($priceMin) {
            $stmt->bindValue(':priceMin', $priceMin);
        }
        if ($priceMax) {
            $stmt->bindValue(':priceMax', $priceMax);
        }

        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
}
?>

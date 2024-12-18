<?php
require_once 'C:\xampp\htdocs\dolicha0.2\config.php';
require_once 'C:\xampp\htdocs\dolicha0.2\models\Product.php';
//include_once 'C:\xampp\htdocs\dolicha0.2\libs\tcpdf\tcpdf.php';
class ProductController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getProductById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM product WHERE ID_Product = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($row) {
            // Create a new Product object
            return new Product(
                $row['ID_Product'],
                $row['Name'],
                $row['Price'],
                $row['Stock'],
                $row['ID_Category'],
                $row['image']
            );
        }
        return null;
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
            // Default query to fetch all products
            $query = "SELECT ID_Product, Name, Price, Stock, ID_Category, Image FROM product";
            
            // Apply sorting if necessary
            if ($sortBy === 'LastEdited') {
                $query .= " ORDER BY updated_at DESC";
            } elseif ($sortBy === 'Stock') {
                $query .= " ORDER BY Stock DESC";
            } elseif ($sortBy === 'Price') {
                $query .= " ORDER BY Price ASC";
            } else {
                // Default sorting by product ID if no sort is specified
                $query .= " ORDER BY ID_Product ASC";
            }
    
            // Execute the query
            $stmt = $this->pdo->query($query);
    
            // Initialize an array to store the products
            $products = [];
    
            // Fetch each product and map it to a Product object
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $products[] = new Product(
                    $row['ID_Product'],
                    $row['Name'],
                    $row['Price'],
                    $row['Stock'],
                    $row['ID_Category'],
                    $row['Image'] ?? null // Handling null image field
                );
            }
    
            return $products;
        } catch (PDOException $e) {
            // Log the error and return an empty array if something goes wrong
            error_log("Error fetching all products: " . $e->getMessage());
            return []; // Return an empty array in case of failure
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
    public function generatePDF($categoryId) {
        // Create new PDF document
        $pdf = new TCPDF();
        $pdf->SetCreator('E-Commerce Admin');
        $pdf->SetTitle('Product Catalog');
    
        // Add a new page
        $pdf->AddPage();
    
        // Fetch data
        $categoryName = $this->getCategoryNameById($categoryId);
        if (!$categoryName) {
            $pdf->SetFont('helvetica', '', 12);
            $pdf->Cell(0, 10, "Category not found", 0, 1, 'C');
            $pdf->Output('Product_Catalog.pdf', 'D');
            return;
        }
    
        // Fetch products for this category
        $products = $this->getAllProductsForCategory($categoryId);
    
        // Add header
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, "Product Catalog: $categoryName", 0, 1, 'C');
        $pdf->Ln(5);
    
        // Add table headers
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(30, 10, 'ID', 1);
        $pdf->Cell(50, 10, 'Name', 1);
        $pdf->Cell(30, 10, 'Price', 1);
        $pdf->Cell(30, 10, 'Stock', 1);
        $pdf->Ln();
    
        // Add product rows
        $pdf->SetFont('helvetica', '', 10);
        foreach ($products as $product) {
            $pdf->Cell(30, 10, $product['ID_Product'], 1);
            $pdf->Cell(50, 10, $product['Name'], 1);
            $pdf->Cell(30, 10, $product['Price'] . ' $', 1);
            $pdf->Cell(30, 10, $product['Stock'], 1);
            $pdf->Ln();
        }
    
        // Output PDF for download
        $pdf->Output('Product_Catalog.pdf', 'D');
    }
    
    public function getAllProductsForCategory($categoryId) {
        try {
            $stmt = $this->pdo->prepare("SELECT ID_Product, Name, Price, Stock FROM product WHERE ID_Category = :categoryId");
            $stmt->execute(['categoryId' => $categoryId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching products for category: " . $e->getMessage());
            return [];
        }
    }
    
    
    
}
?>

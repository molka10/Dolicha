<?php
require_once 'C:\xampp\htdocs\dolicha0.2\models\product.php'; // Include the Product model

class ProductController {
    private $pdo; // Database connection object

    // Constructor to initialize database connection
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Method to fetch all products
    public function getAllProducts() {
        $sql = "SELECT * FROM produit"; // Assuming your table name is `produit`
        $stmt = $this->pdo->query($sql);
        $products = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $product = new Product($row['Idproduit'], $row['nom'], $row['prix']);
            $products[] = $product;
        }

        return $products;
    }

    // Method to fetch a product by its ID
    public function getProductById($Idproduit) {
        $sql = "SELECT * FROM produit WHERE Idproduit = :Idproduit";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['Idproduit' => $Idproduit]);

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return new Product($row['Idproduit'], $row['nom'], $row['prix']);
        }

        return null; // Return null if no product is found
    }

    // Method to add a new product
    public function addProduct($nom, $prix) {
        $sql = "INSERT INTO produit (nom, prix) VALUES (:nom, :prix)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'nom' => $nom,
            'prix' => $prix
        ]);

        return $this->pdo->lastInsertId(); // Return the ID of the newly added product
    }

    // Method to update a product
    public function updateProduct($Idproduit, $nom, $prix) {
        $sql = "UPDATE produit SET nom = :nom, prix = :prix WHERE Idproduit = :Idproduit";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'Idproduit' => $Idproduit,
            'nom' => $nom,
            'prix' => $prix
        ]);
    }

    // Method to delete a product
    public function deleteProduct($Idproduit) {
        $sql = "DELETE FROM produit WHERE Idproduit = :Idproduit";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['Idproduit' => $Idproduit]);
    }
}
?>

<?php
require_once 'C:\xampp\htdocs\dolicha0.2\models\cart.php';
require_once 'C:\xampp\htdocs\dolicha0.2\config.php';
class PanierController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getProductsByCartId($Idpanier) {
        $query = "
            SELECT p.Name AS product_name, p.Price AS product_price, p.Stock AS product_stock, p.image AS product_image, pi.quantity
            FROM panier_items pi
            JOIN product p ON pi.Idproduit = p.ID_Product 
            WHERE pi.Idpanier = :Idpanier
        ";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['Idpanier' => $Idpanier]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Return all matching products
    }


    public function insertOrder($Iduser, $panierId, $nom_client, $status) {
        $query = "INSERT INTO commande (nom_client, Idpanier, date, status) VALUES (:nom_client, :Idpanier, NOW(), :status)";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([
            ':nom_client' => $nom_client,
            ':Idpanier' => $panierId,
            ':status' => $status,
        ]);
    }

    public function deletePanier($Idpanier) {
        // Start a transaction
        $this->pdo->beginTransaction();
        try {
            // First, delete items associated with the cart
            $deleteItemsQuery = "DELETE FROM panier_items WHERE Idpanier = :Idpanier";
            $stmt = $this->pdo->prepare($deleteItemsQuery);
            $stmt->execute(['Idpanier' => $Idpanier]);
    
            // Now, delete the cart
            $deleteCartQuery = "DELETE FROM panier WHERE Idpanier = :Idpanier";
            $stmt = $this->pdo->prepare($deleteCartQuery);
            $stmt->execute(['Idpanier' => $Idpanier]);
    
            // Commit the transaction
            $this->pdo->commit();
            return true; // Deletion was successful
        } catch (PDOException $e) {
            // Rollback the transaction if there was an error
            $this->pdo->rollBack();
            echo "Error deleting cart: " . $e->getMessage();
            return false; // Deletion failed
        }
    }

    public function getExistingCartDetails($Idpanier) {
        // Prepare the SQL query to fetch cart details
        $query = "SELECT Iduser, total, status FROM panier WHERE Idpanier = :Idpanier"; // Fetch Iduser, total, and status
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['Idpanier' => $Idpanier]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Return the entire row as an associative array
    }

    // Method to get an existing cart ID for a user
    public function getExistingCartId($userId) {
        $query = "SELECT Idpanier FROM panier WHERE Iduser = :userId AND status = 0"; // 0 means cart is not confirmed
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetchColumn();
    }

    // Method to create a new cart
    public function createPanier($userId, $total, $status) {
        $query = "INSERT INTO panier (Iduser, total, status) VALUES (:userId, :total, :status)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['userId' => $userId, 'total' => $total, 'status' => $status]);
        return $this->pdo->lastInsertId();  // Return the ID of the newly created cart
    }

    // Method to add a product to the panier_items table
    public function addProductToCart($panierId, $productId, $quantity) {
        // Check if product exists and has enough stock
        $stockQuery = "SELECT Stock FROM product WHERE ID_Product = :productId";
        $stockStmt = $this->pdo->prepare($stockQuery);
        $stockStmt->execute(['productId' => $productId]);
        $stock = $stockStmt->fetchColumn();

        if ($stock === false || $stock < $quantity) {
            throw new Exception("Insufficient stock for product ID $productId.");
        }

        // Insert the product into the cart
        $query = "INSERT INTO panier_items (Idpanier, Idproduct, quantity) VALUES (:panierId, :productId, :quantity)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['panierId' => $panierId, 'productId' => $productId, 'quantity' => $quantity]);


    }

    // Method to update the cart
    public function updatePanier($idpanier, $total, $status) {
        try {
            $sql = "UPDATE panier SET total = :total, status = :status WHERE Idpanier = :idpanier";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':idpanier', $idpanier, PDO::PARAM_INT);
            $stmt->bindParam(':total', $total, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_INT);
            $stmt->execute();
            return true; // Return true if the update was successful
        } catch (PDOException $e) {
            echo "Error updating panier: " . $e->getMessage();
            return false; // Return false if the update failed
        }
    }

    // Method to get all carts
    public function getAllPanier() {
        $query = "SELECT * FROM panier"; // Query to select all records from the panier table
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all results as an associative array
    }
}
?>
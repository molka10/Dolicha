<?php
require_once 'C:\xampp\htdocs\dolicha0.2\model\cart.php';
require_once 'C:\xampp\htdocs\dolicha0.2\config.php';
class PanierController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getProductsByCartId($Idpanier) {
        $query = "
            SELECT p.nom, pi.quantity 
            FROM panier_items pi
            JOIN produit p ON pi.Idproduit = p.Idproduit 
            WHERE pi.Idpanier = :Idpanier
        ";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['Idpanier' => $Idpanier]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Return all matching products
    }


    public function insertOrder($userId, $cartId, $status = 1) {
        global $pdo; // Use the PDO instance
        $stmt = $pdo->prepare("INSERT INTO commande (iduser, Idpanier, date, status) VALUES (?, ?, NOW(), ?)");
        return $stmt->execute([$userId, $cartId, $status]);
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
        $query = "INSERT INTO panier_items (Idpanier, Idproduit, quantity) VALUES (:panierId, :productId, :quantity)";
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
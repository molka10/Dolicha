<?php
require_once 'C:\xampp\htdocs\dolicha0.2\models\comande.php';

class CommandeController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createCommande($Iduser, $Idpanier, $date, $status) {
        $sql = "INSERT INTO commande (Iduser, Idpanier, date, status) VALUES (:Iduser, :Idpanier, :date, :status)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['Iduser' => $Iduser, 'Idpanier' => $Idpanier, 'date' => $date, 'status' => $status]);
        return $this->pdo->lastInsertId();
    }

    public function getCommandeById($id)
{
    $stmt = $this->pdo->prepare("SELECT * FROM commande WHERE idcommande = :id");
    $stmt->execute(['id' => $id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data) {
        return new Commande($data['idcommande'], $data['iduser'], $data['Idpanier'], new DateTime($data['date']), $data['status']);
    }
    return null;
}

    // New method to get all commandes
    public function getAllCommandes() {
        $sql = "SELECT * FROM commande WHERE iduser = 1;"; // Adjust if you want specific fields
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function deleteCommande($id) {
        $stmt = $this->pdo->prepare("DELETE FROM commande WHERE idcommande = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}
<?php
class Panier {
    private $idpanier;
    private $iduser;
    private $produits; // Array of produits (products) in the panier
    private $total;
    private $status;

    // Constructor
    public function __construct($idpanier = null, $iduser = null, $produits = [], $total = null, $status = null) {
        $this->idpanier = $idpanier;
        $this->iduser = $iduser;
        $this->produits = $produits;
        $this->total = $total;
        $this->status = $status;
    }

    // Getters
    public function getIdPanier() {
        return $this->idpanier;
    }

    public function getIdUser() {
        return $this->iduser;
    }

    public function getProduits() {
        return $this->produits;
    }

    public function getTotal() {
        return $this->total;
    }

    public function getStatus() {
        return $this->status;
    }

    // Setters
    public function setIdPanier($idpanier) {
        $this->idpanier = $idpanier;
    }

    public function setIdUser($iduser) {
        $this->iduser = $iduser;
    }

    public function setProduits($produits) {
        $this->produits = $produits;
    }

    public function setTotal($total) {
        $this->total = $total;
    }

    public function setStatus($status) {
        $this->status = $status;
    }
}

?>

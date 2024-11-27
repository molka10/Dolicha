<?php
// Product Model without functions, just attributes, getters, and setters
class Product {
    private $idproduit;
    private $nom;
    private $prix;

    // Constructor to initialize the product attributes
    public function __construct($idproduit = null, $nom = '', $prix = 0.00) {
        $this->idproduit = $idproduit;
        $this->nom = $nom;
        $this->prix = $prix;
    }

    // Getter for idproduit
    public function getIdproduit() {
        return $this->idproduit;
    }

    // Setter for idproduit
    public function setIdproduit($idproduit) {
        $this->idproduit = $idproduit;
    }

    // Getter for nom
    public function getNom() {
        return $this->nom;
    }

    // Setter for nom
    public function setNom($nom) {
        $this->nom = $nom;
    }

    // Getter for prix
    public function getPrix() {
        return $this->prix;
    }

    // Setter for prix
    public function setPrix($prix) {
        $this->prix = $prix;
    }
}
?>

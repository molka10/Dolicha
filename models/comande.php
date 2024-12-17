<?php
class Commande {
    private $idcommande;
    private $iduser;
    private $idpanier;
    private $date;
    private $status;

    // Constructor
    public function __construct($idcommande = null, $iduser = null, $idpanier = null, $date = null, $status = null) {
        $this->idcommande = $idcommande;
        $this->iduser = $iduser;
        $this->idpanier = $idpanier;
        $this->date = $date;
        $this->status = $status;
    }

    // Getters
    public function getIdCommande() {
        return $this->idcommande;
    }

    public function getIdUser() {
        return $this->iduser;
    }

    public function getIdPanier() {
        return $this->idpanier;
    }

    public function getDate() {
        return $this->date;
    }

    public function getStatus() {
        return $this->status;
    }

    // Setters
    public function setIdCommande($idcommande) {
        $this->idcommande = $idcommande;
    }

    public function setIdUser($iduser) {
        $this->iduser = $iduser;
    }

    public function setIdPanier($idpanier) {
        $this->idpanier = $idpanier;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function setStatus($status) {
        $this->status = $status;
    }
}

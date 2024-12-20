<?php
class User {
    private $id_user;
    private $nom;
    private $prenom;
    private $usermail;
    private $password;
    private $userRole;
    private $adress;
    private $Nationalite;
    private $ddn;
    private $num;

    public function __construct($data) {
        $this->id_user = $data['id_user'] ?? null;
        $this->nom = $data['nom'] ?? '';
        $this->prenom = $data['prenom'] ?? '';
        $this->usermail = $data['usermail'] ?? '';
        $this->password = $data['password'] ?? '';
        $this->userRole = $data['userRole'] ?? '';
        $this->adress = $data['adress'] ?? '';
        $this->Nationalite = $data['Nationalite'] ?? '';
        $this->ddn = $data['ddn'] ?? '';
        $this->num = $data['num'] ?? '';
    }

    // Getters
    public function getIdUser() {
        return $this->id_user;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function getUsermail() {
        return $this->usermail;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getUserRole() {
        return $this->userRole;
    }

    public function getAdress() {
        return $this->adress;
    }

    public function getNationalite() {
        return $this->Nationalite;
    }

    public function getDdn() {
        return $this->ddn;
    }

    public function getNum() {
        return $this->num;
    }

    // Setters
    public function setIdUser($id_user) {
        $this->id_user = $id_user;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function setUsermail($usermail) {
        $this->usermail = $usermail;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setUserRole($userRole) {
        $this->userRole = $userRole;
    }

    public function setAdress($adress) {
        $this->adress = $adress;
    }

    public function setNationalite($Nationalite) {
        $this->Nationalite = $Nationalite;
    }

    public function setDdn($ddn) {
        $this->ddn = $ddn;
    }

    public function setNum($num) {
        $this->num = $num;
    }
}

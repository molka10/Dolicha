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

        public function __construct($id_user, $nom, $prenom, $usermail, $password, $userRole, $adress, $Nationalite, $ddn, $num) {
            $this->id_user = $id_user;
            $this->nom = $nom;
            $this->prenom = $prenom;
            $this->usermail = $usermail;
            $this->password = $password;
            $this->userRole = $userRole;
            $this->adress = $adress;
            $this->Nationalite = $Nationalite;
            $this->ddn = $ddn;
            $this->num = $num;
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
?>
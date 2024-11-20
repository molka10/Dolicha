<?php
// models/User.php
class User {
    private $db;

    public function __construct() {
        // Connexion à la base de données avec les bons identifiants
        $this->db = new PDO("mysql:host=localhost;dbname=dolicha", "root", "");
    }

    // Méthode d'inscription
    public function register($usermail, $password, $userRole, $adress, $Nationalite, $ddn, $num) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT); // Hasher le mot de passe

        // Préparer la requête SQL pour insérer un nouvel utilisateur
        $query = "INSERT INTO user (usermail, password, userRole, adress, Nationalite, ddn, num) 
                  VALUES (:usermail, :password, :userRole, :adress, :Nationalite, :ddn, :num)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':usermail', $usermail);
        $stmt->bindParam(':password', $passwordHash);
        $stmt->bindParam(':userRole', $userRole);
        $stmt->bindParam(':adress', $adress);
        $stmt->bindParam(':Nationalite', $Nationalite);
        $stmt->bindParam(':ddn', $ddn);
        $stmt->bindParam(':num', $num);

        return $stmt->execute(); // Exécuter la requête
    }

    // Méthode de connexion
    public function login($usermail, $password) {
        // Préparer la requête SQL pour vérifier les informations de connexion
        $query = "SELECT * FROM user WHERE usermail = :usermail";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':usermail', $usermail);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier si l'utilisateur existe et si le mot de passe est correct
        if ($user && password_verify($password, $user['password'])) {
            return $user; // L'utilisateur est authentifié
        } else {
            return false; // Identifiants incorrects
        }
    }

    // Méthode pour récupérer tous les utilisateurs
    public function getAllUsers() {
        $query = "SELECT * FROM user";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour supprimer un utilisateur par numéro
    public function deleteUserByNum($num) {
        $query = "DELETE FROM user WHERE num = :num";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':num', $num);
        return $stmt->execute();
    }

    // Nouvelle méthode : récupérer un utilisateur par numéro
   // models/User.php
   public function getUserByNum($num) {
    $sql = "SELECT * FROM user WHERE num = :num";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['num' => $num]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


    // Nouvelle méthode : mettre à jour les informations d'un utilisateur
    public function updateUser($num, $usermail, $userRole, $adress, $Nationalite, $ddn) {
        $query = "UPDATE user 
                  SET usermail = :usermail, userRole = :userRole, adress = :adress, Nationalite = :Nationalite, ddn = :ddn 
                  WHERE num = :num";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':usermail', $usermail);
        $stmt->bindParam(':userRole', $userRole);
        $stmt->bindParam(':adress', $adress);
        $stmt->bindParam(':Nationalite', $Nationalite);
        $stmt->bindParam(':ddn', $ddn);
        $stmt->bindParam(':num', $num);

        return $stmt->execute();
    }
}
?>

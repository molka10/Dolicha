<?php
    require_once __DIR__ . '/../models/user.php';
    include_once __DIR__ . '/../config.php';

    // Initialiser la connexion à la base de données
    $db = (new Database())->getConnection();

    // Vérifier si une requête POST ou GET a été envoyée
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['action'])) {
            $action = $_POST['action'];
            
            // Action: Inscription
            if ($action == 'signup') {
                if (isset($_POST['nom'], $_POST['prenom'], $_POST['usermail'], $_POST['password'], $_POST['confirmPassword'], $_POST['userRole'], $_POST['adress'], $_POST['Nationalite'], $_POST['ddn'], $_POST['num'])) {
                    $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
                    $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_STRING);
                    $usermail = filter_input(INPUT_POST, 'usermail', FILTER_SANITIZE_EMAIL);
                    $password = $_POST['password'];
                    $confirmPassword = $_POST['confirmPassword'];
                    $userRole = filter_input(INPUT_POST, 'userRole', FILTER_SANITIZE_STRING);
                    $adress = filter_input(INPUT_POST, 'adress', FILTER_SANITIZE_STRING);
                    $Nationalite = filter_input(INPUT_POST, 'Nationalite', FILTER_SANITIZE_STRING);
                    $ddn = $_POST['ddn'];
                    $num = filter_input(INPUT_POST, 'num', FILTER_SANITIZE_STRING);

                    if ($password === $confirmPassword) {
                        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                        $query = "INSERT INTO user (nom, prenom, usermail, password, userRole, adress, Nationalite, ddn, num) 
                                VALUES (:nom, :prenom, :usermail, :password, :userRole, :adress, :Nationalite, :ddn, :num)";
                        $stmt = $db->prepare($query);
                        $stmt->bindParam(':nom', $nom);
                        $stmt->bindParam(':prenom', $prenom);
                        $stmt->bindParam(':usermail', $usermail);
                        $stmt->bindParam(':password', $passwordHash);
                        $stmt->bindParam(':userRole', $userRole);
                        $stmt->bindParam(':adress', $adress);
                        $stmt->bindParam(':Nationalite', $Nationalite);
                        $stmt->bindParam(':ddn', $ddn);
                        $stmt->bindParam(':num', $num);

                        if ($stmt->execute()) {
                            header("Location: ..//view/front_office/login.html");
                            
                        
                            
                        } else {
                            echo "Erreur lors de l'inscription.";
                        }
                    } else {
                        echo "Les mots de passe ne correspondent pas!";
                    }
                }
            }

            // Action: Supprimer un utilisateur
            elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'delete') {
                $id_user = $_POST['id_user'];
            
                // Supprimer l'utilisateur
                $query = "DELETE FROM user WHERE id_user = :id_user";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':id_user', $id_user);
                
                if ($stmt->execute()) {
                    // Redirection après la suppression
                    header("Location: ../view/back_office/molka.php");
                    exit();
                } else {
                    echo "Erreur lors de la suppression.";
                }
            }
            

            // Action: Modifier un utilisateur
            elseif ($action == 'edit' && isset($_POST['id_user'])) {
                $id_user = $_POST['id_user'];
                $nom = filter_input(INPUT_POST, 'Nom', FILTER_SANITIZE_STRING);
                $prenom = filter_input(INPUT_POST, 'Prenom', FILTER_SANITIZE_STRING);
                $usermail = filter_input(INPUT_POST, 'usermail', FILTER_SANITIZE_EMAIL);
                $userRole = filter_input(INPUT_POST, 'userRole', FILTER_SANITIZE_STRING);
                $adress = filter_input(INPUT_POST, 'adress', FILTER_SANITIZE_STRING);
                $Nationalite = filter_input(INPUT_POST, 'Nationalite', FILTER_SANITIZE_STRING);
                $ddn = $_POST['ddn'];  // Date de naissance
                $num = filter_input(INPUT_POST, 'num', FILTER_SANITIZE_STRING);

                $query = "UPDATE user SET nom = :nom, prenom = :prenom, usermail = :usermail, userRole = :userRole, adress = :adress, Nationalite = :Nationalite, ddn = :ddn, num = :num WHERE id_user = :id_user";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':id_user', $id_user);
                $stmt->bindParam(':nom', $nom);
                $stmt->bindParam(':prenom', $prenom);
                $stmt->bindParam(':usermail', $usermail);
                $stmt->bindParam(':userRole', $userRole);
                $stmt->bindParam(':adress', $adress);
                $stmt->bindParam(':Nationalite', $Nationalite);
                $stmt->bindParam(':ddn', $ddn);
                $stmt->bindParam(':num', $num);

                if ($stmt->execute()) {
                    echo "Utilisateur mis à jour avec succès!";
                    // Redirection après la mise à jour
                    header("Location: ../view/back_office/molka.php");
                    exit();
                } else {
                    echo "Erreur lors de la mise à jour.";
                }
            }
        }
    }

    function getUserName($db, $user_id) {
        $query = "SELECT nom FROM user WHERE id_user = :user_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn(); // Retourne le champ "name"
    }

    function getUserById($db, $id_user) {
        $query = "SELECT * FROM user WHERE id_user = :id_user";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id_user', $id_user);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if user was found
        if ($result === false) {
            return null; // Return null if no user was found
        }
        return $result;
    }

    function updateUser($db, $id_user, $nom, $prenom, $usermail, $adress, $Nationalite, $ddn, $num) {
        $query = "UPDATE user SET nom = :nom, prenom = :prenom, usermail = :usermail, adress = :adress, 
                Nationalite = :Nationalite, ddn = :ddn, num = :num WHERE id_user = :id_user";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id_user', $id_user);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':usermail', $usermail);
        $stmt->bindParam(':adress', $adress);
        $stmt->bindParam(':Nationalite', $Nationalite);
        $stmt->bindParam(':ddn', $ddn);
        $stmt->bindParam(':num', $num);

        return $stmt->execute();
    }

    function countAdmins()
    {
        try {
            $pdo = config::getConnexion();
            $query = $pdo->prepare('SELECT COUNT(*) as count FROM user');
            $query->execute();

            $result = $query->fetch(PDO::FETCH_ASSOC);

            return $result['count'];
        } catch (PDOException $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Fonction pour compter les utilisateurs par rôle

    // Inclure la classe Database et la connexion
    // Initialiser la connexion à la base de données

    // Définir la fonction pour récupérer le nombre d'utilisateurs par rôle
    function countUsersByRole($db, $role) {
        $query = "SELECT COUNT(*) FROM user WHERE userRole = :role";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':role', $role);
        $stmt->execute();
        return $stmt->fetchColumn(); // Retourne le nombre d'utilisateurs avec ce rôle
    }

    // Récupérer les statistiques
    $totalUsers = countUsersByRole($db, 'user');
    $totalAdmins = countUsersByRole($db, 'admin');
    $totalVendeurs = countUsersByRole($db, 'vendeur');


    // Fonction de récupération des utilisateurs (avec recherche)
    function getAllUsers($db, $search = null) {
        $query = "SELECT * FROM user";
        
        if ($search) {
            $query .= " WHERE nom LIKE :search OR prenom LIKE :search OR usermail LIKE :search";
        }

        $stmt = $db->prepare($query);

        if ($search) {
            $searchTerm = "%" . $search . "%"; // Ajoute les jokers pour une recherche partielle
            $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
?>
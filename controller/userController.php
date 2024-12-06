<?php
require_once __DIR__ . '/../models/user.php';
include_once 'D:\xampp\htdocs\dolicha\config.php'; // Inclure la classe Database

// Initialiser la connexion à la base de données
$db = (new Database())->getConnection();

// Vérifier si une requête POST ou GET a été envoyée
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        // Action: Connexion
        if ($action == 'login') {
            $usermail = filter_input(INPUT_POST, 'usermail', FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

            if ($usermail && $password) {
                $query = "SELECT * FROM user WHERE usermail = :usermail";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':usermail', $usermail);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user && password_verify($password, $user['password'])) {
                    // Démarrer la session et stocker l'utilisateur connecté
                    session_start();
                    $_SESSION['user'] = [
                        'id' => $user['id_user'],
                        'role' => $user['userRole'],
                        'usermail' => $user['usermail']
                    ];

                    // Redirection selon le rôle
                    if ($user['userRole'] == 'admin') {
                        header("Location: ../view/back_office/pages/tables/basic-table.php");
                        exit();
                    } elseif (in_array($user['userRole'], ['user', 'vendeur'])) {
                        header("Location: ../view/front_office/index.html");
                        exit();
                    } else {
                        echo "Rôle utilisateur inconnu!";
                    }
                } else {
                    echo "Identifiants incorrects!";
                }
            } else {
                echo "Les informations de connexion sont incomplètes!";
            }
        }

        // Action: Inscription
        elseif ($action == 'signup') {
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
                        echo "Inscription réussie!";
                    } else {
                        echo "Erreur lors de l'inscription.";
                    }
                } else {
                    echo "Les mots de passe ne correspondent pas!";
                }
            }
        }

        // Action: Supprimer un utilisateur
        elseif ($action == 'delete' && isset($_POST['id_user'])) {
            $id_user = $_POST['id_user'];
            $query = "DELETE FROM user WHERE id_user = :id_user";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id_user', $id_user);
            if ($stmt->execute()) {
                header("Location: ../view/back_office/pages/tables/basic-table.php");
                exit();
            } else {
                echo "Erreur de suppression.";
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
                header("Location: ../view/back_office/pages/tables/basic-table.php");
                exit();
            } else {
                echo "Erreur lors de la mise à jour.";
            }
        }
    }
}

function getUserById($db, $id_user) {
    $query = "SELECT * FROM user WHERE id_user = :id_user";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Fonction de récupération des utilisateurs (avec recherche)
function getAllUsers($db, $search = null) {
    $query = "SELECT * FROM user";
    if ($search) {
        $query .= " WHERE nom LIKE :search OR prenom LIKE :search OR usermail LIKE :search";
    }

    $stmt = $db->prepare($query);

    if ($search) {
        $searchTerm = "%" . $search . "%"; 
        $stmt->bindParam(':search', $searchTerm);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

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
            if (isset($_POST['usermail'], $_POST['password'])) {
                $usermail = $_POST['usermail'];
                $password = $_POST['password'];

                // Requête SQL pour vérifier les identifiants
                $query = "SELECT * FROM user WHERE usermail = :usermail";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':usermail', $usermail);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user && password_verify($password, $user['password'])) {
                    header("Location: ../view/front_office/index.html");
                    exit();
                } else {
                    echo "Identifiants incorrects!";
                }
            } else {
                echo "Les informations de connexion sont manquantes!";
            }
        }
        // Action: Inscription
        elseif ($action == 'signup') {
            if (isset($_POST['usermail'], $_POST['password'], $_POST['confirmPassword'], $_POST['userRole'], $_POST['adress'], $_POST['Nationalite'], $_POST['ddn'], $_POST['num'])) {
                $usermail = $_POST['usermail'];
                $password = $_POST['password'];
                $confirmPassword = $_POST['confirmPassword'];
                $userRole = $_POST['userRole'];
                $adress = $_POST['adress'];
                $Nationalite = $_POST['Nationalite'];
                $ddn = $_POST['ddn'];
                $num = $_POST['num'];

                if ($password === $confirmPassword) {
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    $query = "INSERT INTO user (usermail, password, userRole, adress, Nationalite, ddn, num) 
                              VALUES (:usermail, :password, :userRole, :adress, :Nationalite, :ddn, :num)";
                    $stmt = $db->prepare($query);
                    $stmt->bindParam(':usermail', $usermail);
                    $stmt->bindParam(':password', $passwordHash);
                    $stmt->bindParam(':userRole', $userRole);
                    $stmt->bindParam(':adress', $adress);
                    $stmt->bindParam(':Nationalite', $Nationalite);
                    $stmt->bindParam(':ddn', $ddn);
                    $stmt->bindParam(':num', $num);

                    if ($stmt->execute()) {
                        header("Location: ../view/front_office/login.html");
                        exit();
                    } else {
                        echo "Erreur lors de l'inscription.";
                    }
                } else {
                    echo "Les mots de passe ne correspondent pas!";
                }
            } else {
                echo "Certains champs sont manquants!";
            }
        }
        // Action: Suppression
        elseif ($action == 'delete' && isset($_POST['id_user'])) {
            $id_user = $_POST['id_user'];
            if (deleteUserById($db, $id_user)) {
                echo "Utilisateur supprimé avec succès!";
            } else {
                echo "Erreur lors de la suppression de l'utilisateur.";
            }
        }
        // Action: Modification
        elseif ($action == 'edit' && isset($_POST['id_user'], $_POST['usermail'], $_POST['userRole'], $_POST['adress'], $_POST['Nationalite'], $_POST['ddn'], $_POST['num'])) {
            $id_user = $_POST['id_user'];
            $usermail = $_POST['usermail'];
            $userRole = $_POST['userRole'];
            $adress = $_POST['adress'];
            $Nationalite = $_POST['Nationalite'];
            $ddn = $_POST['ddn'];
            $num = $_POST['num'];

            if (updateUserById($db, $id_user, $usermail, $userRole, $adress, $Nationalite, $ddn, $num)) {
                echo "Utilisateur mis à jour avec succès!";
                header("Location: "); // Redirection après succès
                exit();
            } else {
                echo "Erreur lors de la mise à jour de l'utilisateur.";
            }
        }
    } else {
        echo "Aucune action spécifiée!";
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['id_user'])) {
        $id_user = $_GET['id_user'];
        $user = getUserById($db, $id_user);
        echo json_encode($user);
    } else {
        // Affichage des utilisateurs
        $users = getAllUsers($db);
    }
}

// Fonction pour récupérer tous les utilisateurs
function getAllUsers($db) {
    $query = "SELECT * FROM user";
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour récupérer un utilisateur par ID
function getUserById($db, $id_user) {
    $query = "SELECT * FROM user WHERE id_user = :id_user";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Fonction pour supprimer un utilisateur par ID
function deleteUserById($db, $id_user) {
    $query = "DELETE FROM user WHERE id_user = :id_user";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    return $stmt->execute();
}

// Fonction pour mettre à jour un utilisateur par ID
function updateUserById($db, $id_user, $usermail, $userRole, $adress, $Nationalite, $ddn, $num) {
    $query = "UPDATE user 
              SET usermail = :usermail, userRole = :userRole, adress = :adress, 
                  Nationalite = :Nationalite, ddn = :ddn, num = :num 
              WHERE id_user = :id_user";
    $stmt = $db->prepare($query);

    $stmt->bindParam(':usermail', $usermail);
    $stmt->bindParam(':userRole', $userRole);
    $stmt->bindParam(':adress', $adress);
    $stmt->bindParam(':Nationalite', $Nationalite);
    $stmt->bindParam(':ddn', $ddn);
    $stmt->bindParam(':num', $num);
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);

    return $stmt->execute();
}
?>

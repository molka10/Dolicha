<?php
require_once 'C:\xampp\htdocs\dolicha0.2\config.php';
require_once 'C:\xampp\htdocs\dolicha0.2\models\user.php';

class UserController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function handleRequest() {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'])) {
            $action = $_POST['action'];
            switch ($action) {
                case 'login':
                    $this->login();
                    break;
                case 'signup':
                    $this->signup();
                    break;
                case 'delete':
                    $this->deleteUser();
                    break;
                case 'edit':
                    $this->editUser();
                    break;
                default:
                    echo "Action inconnue.";
            }
        }
    }

    private function login() {
        $usermail = filter_input(INPUT_POST, 'usermail', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        if ($usermail && $password) {
            $query = "SELECT * FROM user WHERE usermail = :usermail";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':usermail', $usermail);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user'] = [
                    'id' => $user['id_user'],
                    'role' => $user['userRole'],
                    'usermail' => $user['usermail']
                ];

                if ($user['userRole'] == 'admin') {
                    header("Location: ../back_office/index.php");
                } elseif (in_array($user['userRole'], ['user', 'vendeur'])) {
                    header("Location: ../front_office/index.php");
                } else {
                    echo "Rôle utilisateur inconnu!";
                }
                exit();
            } else {
                echo "Identifiants incorrects!";
            }
        } else {
            echo "Les informations de connexion sont incomplètes!";
        }
    }

    private function signup() {
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
                $stmt = $this->pdo->prepare($query);
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
                    header("Location: ../view/front_office/login.php");
                    exit();
                } else {
                    echo "Erreur lors de l'inscription.";
                }
            } else {
                echo "Les mots de passe ne correspondent pas!";
            }
        }
    }

    private function deleteUser() {
        $id_user = $_POST['id_user'];

        $query = "DELETE FROM user WHERE id_user = :id_user";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_user', $id_user);

        if ($stmt->execute()) {
            header("Location: ../view/back_office/index.php");
            exit();
        } else {
            echo "Erreur lors de la suppression.";
        }
    }

    private function editUser() {
        $id_user = $_POST['id_user'];
        $nom = filter_input(INPUT_POST, 'Nom', FILTER_SANITIZE_STRING);
        $prenom = filter_input(INPUT_POST, 'Prenom', FILTER_SANITIZE_STRING);
        $usermail = filter_input(INPUT_POST, 'usermail', FILTER_SANITIZE_EMAIL);
        $userRole = filter_input(INPUT_POST, 'userRole', FILTER_SANITIZE_STRING);
        $adress = filter_input(INPUT_POST, 'adress', FILTER_SANITIZE_STRING);
        $Nationalite = filter_input(INPUT_POST, 'Nationalite', FILTER_SANITIZE_STRING);
        $ddn = $_POST['ddn'];
        $num = filter_input(INPUT_POST, 'num', FILTER_SANITIZE_STRING);

        $query = "UPDATE user SET nom = :nom, prenom = :prenom, usermail = :usermail, userRole = :userRole, adress = :adress, Nationalite = :Nationalite, ddn = :ddn, num = :num WHERE id_user = :id_user";
        $stmt = $this->pdo->prepare($query);
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
            header("Location: ../view/back_office/index.php");
            exit();
        } else {
            echo "Erreur lors de la mise à jour.";
        }
    }

    public function getUserName($user_id) {
        $query = "SELECT nom FROM user WHERE id_user = :user_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getUserById($id_user) {
        $query = "SELECT * FROM user WHERE id_user = :id_user";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_user', $id_user);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getAllUsers($search = null) {
        $query = "SELECT * FROM user";
        if ($search) {
            $query .= " WHERE nom LIKE :search OR prenom LIKE :search OR usermail LIKE :search";
        }
        $stmt = $this->pdo->prepare($query);
        if ($search) {
            $searchTerm = "%" . $search . "%";
            $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Initialisation
$userController = new UserController($pdo);
$userController->handleRequest();
?>

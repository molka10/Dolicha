<?php
include_once '../../models/user.php';
include_once '../../config.php'; // Inclure la classe Database

// Initialiser la connexion à la base de données
$db = (new Database())->getConnection();

// Vérifier si une requête POST a été envoyée
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'login') {
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
                header("Location: ../back_office/pages/tables/basic-table.php");
                exit();
            } 
            elseif (in_array($user['userRole'], ['user', 'vendeur'])) {
                header("Location: ../front_office/index.php");
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
} else {
    echo "Aucune action spécifiée!";
}
?>

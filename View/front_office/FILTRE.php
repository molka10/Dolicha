<?php
// Include necessary files
require_once 'C:\xampp\htdocs\dolicha0.2\models\user.php';
require_once 'C:\xampp\htdocs\dolicha0.2\config.php'; // Include Database configuration file
require_once 'C:\xampp\htdocs\dolicha0.2\controllers\userController.php';

// Ensure session is started
session_start();

// Check if the request is a POST and contains 'action' parameter
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'login') {
    // Sanitize input values
    $usermail = filter_input(INPUT_POST, 'usermail', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    if ($usermail && $password) {
        try {
            // Prepare the SQL query to fetch the user from the database
            $query = "SELECT * FROM user WHERE usermail = :usermail";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':usermail', $usermail, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verify user and password
            if ($user && password_verify($password, $user['password'])) {
                // Store user data in session
                $_SESSION['user'] = [
                    'id' => $user['id_user'],
                    'role' => $user['userRole'],
                    'usermail' => $user['usermail']
                ];
                var_dump($_SERVER['REQUEST_URI']);
                exit();                

                if ($user['userRole'] == 'admin') {
                    header("Location: /dolicha0.2/View/back_office/molka.php");  // This should work if path is correct
                    exit();
                } elseif (in_array($user['userRole'], ['user', 'vendeur'])) {
                    header("Location: index.php");
                exit();


                } else {
                    echo "Rôle utilisateur inconnu!";
                }                              
            } else {
                echo "Identifiants incorrects!";
            }
        } catch (PDOException $e) {
            echo "Erreur de base de données: " . $e->getMessage();
        }
    } else {
        echo "Les informations de connexion sont incomplètes!";
    }
} else {
    echo "Aucune action spécifiée!";
}
?>

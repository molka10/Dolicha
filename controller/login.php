<?php
// login.php (Controller)
include_once '../models/user.php'; // Inclure le modèle User

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $usermail = $_POST['usermail'];
    $password = $_POST['password'];

    // Créer une instance de User
    $user = new User();

    // Vérifier les informations de connexion
    $loggedInUser = $user->login($usermail, $password);

    if ($loggedInUser) {
        // L'utilisateur est connecté, rediriger vers la page d'accueil
        header("Location: ../view/front_office/index.html");
    } else {
        echo "Identifiants incorrects!";
    }
}
?>

<?php
// signup.php (Controller)
include_once '../models/user.php'; // Inclure le modèle User

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifiez si le champ 'confirmPassword' existe dans $_POST
    if (isset($_POST['confirmPassword'])) {
        // Récupérer les données du formulaire
        $usermail = $_POST['usermail'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];
        $userRole = $_POST['userRole'];
        $adress = $_POST['adress'];
        $Nationalite = $_POST['Nationalite'];
        $ddn = $_POST['ddn'];
        $num = $_POST['num'];

        // Vérifier si les mots de passe correspondent
        if ($password === $confirmPassword) {
            // Créer une instance de User
            $user = new User();
            $result = $user->register($usermail, $password, $userRole, $adress, $Nationalite, $ddn, $num);

            if ($result) {
                header("Location: ../view/front_office/login.html "); // Rediriger vers la page de connexion
            } else {
                echo "Erreur d'inscription";
            }
        } else {
            echo "Les mots de passe ne correspondent pas!";
        }
    } else {
        echo "Le champ de confirmation du mot de passe est manquant!";
    }
}
?>

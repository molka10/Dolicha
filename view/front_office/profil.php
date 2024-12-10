<?php
session_start();
require_once '../../controller/userController.php'; // Inclure le contrôleur d'utilisateur
require_once '../../config.php'; // Inclure la connexion à la base de données

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header("Location: login.php"); // Rediriger vers la page de connexion si non connecté
    exit();
}

// Récupérer l'ID de l'utilisateur connecté et ses informations
$user_id = $_SESSION['user']['id'];
$user = getUserById($db, $user_id); // Récupérer les informations de l'utilisateur par ID

// Traitement de la mise à jour des informations
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'edit') {
    $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
    $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_STRING);
    $usermail = filter_input(INPUT_POST, 'usermail', FILTER_SANITIZE_EMAIL);
    $userRole = filter_input(INPUT_POST, 'userRole', FILTER_SANITIZE_STRING);
    $adress = filter_input(INPUT_POST, 'adress', FILTER_SANITIZE_STRING);
    $Nationalite = filter_input(INPUT_POST, 'Nationalite', FILTER_SANITIZE_STRING);
    $ddn = $_POST['ddn'];  // Date de naissance
    $num = filter_input(INPUT_POST, 'num', FILTER_SANITIZE_STRING);

    // Appel à la fonction de mise à jour de l'utilisateur dans le contrôleur
}
?>

<!DOCTYPE html>
<html lang="fr" class="no-js">
<head>
    <meta charset="UTF-8">
    <title>Modifier Profil</title>
    <style>
        /* Style de base pour la page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: white;
            padding: 10px 0;
            text-align: center;
        }

        main {
            padding: 20px;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"], input[type="email"], input[type="date"], input[type="tel"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        footer {
            text-align: center;
            padding: 10px;
            background-color: #333;
            color: white;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<header>
    <!-- Ici, tu peux inclure un menu ou une barre de navigation si tu en as un -->
    <h1>Bienvenue sur votre profil</h1>
</header>

<main>
    <div class="container">
        <h2>Modifier mon profil</h2>

        <!-- Formulaire de modification du profil -->
        <form method="POST" action="">
            <input type="hidden" name="action" value="edit">

            <div class="form-group">
                <label for="nom">Nom:</label>
                <input type="text" name="nom" id="nom" value="<?= htmlspecialchars($user['nom']); ?>" required>
            </div>

            <div class="form-group">
                <label for="prenom">Prénom:</label>
                <input type="text" name="prenom" id="prenom" value="<?= htmlspecialchars($user['prenom']); ?>" required>
            </div>

            <div class="form-group">
                <label for="usermail">Email:</label>
                <input type="email" name="usermail" id="usermail" value="<?= htmlspecialchars($user['usermail']); ?>" required>
            </div>

            <div class="form-group">
                <label for="userRole">Rôle:</label>
                <input type="text" name="userRole" id="userRole" value="<?= htmlspecialchars($user['userRole']); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="adress">Adresse:</label>
                <input type="text" name="adress" id="adress" value="<?= htmlspecialchars($user['adress']); ?>" required>
            </div>

            <div class="form-group">
                <label for="Nationalite">Nationalité:</label>
                <input type="text" name="Nationalite" id="Nationalite" value="<?= htmlspecialchars($user['Nationalite']); ?>" required>
            </div>

            <div class="form-group">
                <label for="ddn">Date de naissance:</label>
                <input type="date" name="ddn" id="ddn" value="<?= htmlspecialchars($user['ddn']); ?>" required>
            </div>

            <div class="form-group">
                <label for="num">Numéro de téléphone:</label>
                <input type="text" name="num" id="num" value="<?= htmlspecialchars($user['num']); ?>" required>
            </div>

            <button type="submit">edit</button>
        </form>
    </div>
</main>

<footer>
    <!-- Footer de ton site -->
    <p>&copy; 2024 Dolicha </p>
</footer>

</body>
</html>

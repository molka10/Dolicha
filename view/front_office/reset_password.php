<?php
// reset_password.php

// Vérifier si le token est fourni
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Connexion à la base de données
    include_once '../../config.php';
    $db = (new Database())->getConnection();

    // Vérifier si le token existe et s'il est valide
    $query = "SELECT * FROM user WHERE reset_token = :token AND reset_expires > :now";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':token', $token);
    $stmt->bindParam(':now', date('U'));
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Vérifier si le formulaire est soumis pour mettre à jour le mot de passe
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['password'])) {
            $password = $_POST['password'];

            // Hacher le nouveau mot de passe
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Mettre à jour le mot de passe dans la base de données
            $updateQuery = "UPDATE user SET password = :password, reset_token = NULL, reset_expires = NULL WHERE id_user = :id";
            $updateStmt = $db->prepare($updateQuery);
            $updateStmt->bindParam(':password', $hashedPassword);
            $updateStmt->bindParam(':id', $user['id_user']);
            $updateStmt->execute();

            echo "Votre mot de passe a été réinitialisé avec succès!";
        }
    } else {
        echo "Le lien de réinitialisation est invalide ou a expiré.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Réinitialiser le Mot de Passe</title>
</head>
<body>
    <h2>Réinitialiser votre mot de passe</h2>
    <form method="POST" action="reset_password.php?token=<?php echo $_GET['token']; ?>">
        <label for="password">Nouveau mot de passe :</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Réinitialiser</button>
    </form>
</body>
</html>

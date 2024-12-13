<?php


// Vérifier si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    if ($email) {
        // Connexion à la base de données
        include_once '../../config.php';
        $db = (new Database())->getConnection();

        // Vérifier si l'email existe dans la base de données
        $query = "SELECT * FROM user WHERE usermail = :email";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Générer un token de réinitialisation
            $token = bin2hex(random_bytes(16));
            $expires = date('U') + 3600; // 1 heure de validité

            // Enregistrer le token dans la base de données
            $updateQuery = "UPDATE user SET reset_token = :token, reset_expires = :expires WHERE usermail = :email";
            $updateStmt = $db->prepare($updateQuery);
            $updateStmt->bindParam(':token', $token);
            $updateStmt->bindParam(':expires', $expires);
            $updateStmt->bindParam(':email', $email);
            $updateStmt->execute();

            // Envoi de l'email avec le lien de réinitialisation
            $resetLink = "http://votre-site.com/reset_password.php?token=" . $token;
            $subject = "Réinitialisation de votre mot de passe";
            $message = "Cliquez sur le lien suivant pour réinitialiser votre mot de passe : " . $resetLink;
            $headers = "From: no-reply@votre-site.com";

            if (mail($email, $subject, $message, $headers)) {
                echo "Un email a été envoyé avec un lien pour réinitialiser votre mot de passe.";
            } else {
                echo "Erreur lors de l'envoi de l'email.";
            }
        } else {
            echo "L'email fourni n'est pas associé à un compte.";
        }
    } else {
        echo "Veuillez entrer un email valide.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mot de Passe Oublié</title>
</head>
<body>
    <h2>Mot de Passe Oublié</h2>
    <form method="POST" action="forgot_password.php">
        <label for="email">Entrez votre email :</label>
        <input type="email" id="email" name="email" required>
        <button type="submit">Envoyer</button>
    </form>
</body>
</html>

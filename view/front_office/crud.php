<?php
require_once '../../models/user.php';

// Instancier l'objet User
$userModel = new User();

// Vérifier si le bouton supprimer a été cliqué
if (isset($_POST['delete'])) {
    $userNum = $_POST['user_num']; // Récupérer le numéro de l'utilisateur
    if ($userModel->deleteUserByNum($userNum)) {
        echo "<p style='color:green;'>Utilisateur supprimé avec succès.</p>";
    } else {
        echo "<p style='color:red;'>Échec de la suppression.</p>";
    }
}

// Récupérer tous les utilisateurs
$users = $userModel->getAllUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Liste des utilisateurs</title>
</head>
<body>
    <h1>Liste des utilisateurs</h1>
    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Num</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Adresse</th>
                <th>Nationalité</th>
                <th>Date de Naissance</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['num']) ?></td>
                    <td><?= htmlspecialchars($user['usermail']) ?></td>
                    <td><?= htmlspecialchars($user['userRole']) ?></td>
                    <td><?= htmlspecialchars($user['adress']) ?></td>
                    <td><?= htmlspecialchars($user['Nationalite']) ?></td>
                    <td><?= htmlspecialchars($user['ddn']) ?></td>
                    <td>
                        <
                        <form method="POST" action="crud.php" style="display:inline;">
                            <input type="hidden" name="user_num" value="<?= htmlspecialchars($user['num']) ?>">
                            <button type="submit" name="delete" onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');">
                                Supprimer
                            </button>
                        </form>
                        <form method="GET" action="update.php">
    <input type="hidden" name="num" value="<?= htmlspecialchars($user['num']) ?>">
    <button type="submit">Modifier</button>
</form>

</form>


</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>

<?php
require_once '../../../../config.php'; // Include Database class
require_once '../../../../controller/userController.php'; // Include user controller functions

// Fetch the selected user
$user = null;
if (isset($_GET['id_user'])) {
    $id_user = $_GET['id_user'];
    $db = (new Database())->getConnection();
    $user = getUserById($db, $id_user); // Assurez-vous que cette fonction retourne un tableau utilisateur
    ob_end_clean();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Utilisateur</title>
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background-color: #f4f5fa;
        }

        .container-scroller {
            display: flex;
        }

        /* Sidebar */
        .sidebar {
            width: 240px;
            background-color: #27293d;
            color: #ffffff;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .sidebar h1 {
            text-align: center;
            padding: 20px;
            margin: 0;
            font-size: 1.5rem;
            background-color: #2b2d42;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            padding: 15px 20px;
            font-size: 1rem;
            color: #cfd4e0;
            cursor: pointer;
        }

        .sidebar ul li:hover {
            background-color: #4b49ac;
            color: #ffffff;
        }

        .content-wrapper {
            flex: 1;
            padding: 20px;
            background-color: #ffffff;
            overflow: auto;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #f4f5fa;
        }

        .navbar .profile-info {
            display: flex;
            align-items: center;
        }

        .navbar .profile-info img {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }

        /* Form box styles for editing user */
        .form-box {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
        }

        .form-box h1 {
            font-size: 1.5rem;
            color: #4B49AC;
            margin-bottom: 20px;
        }

        .inputbox {
            margin-bottom: 15px;
        }

        .inputbox label {
            font-size: 1rem;
            color: #333;
        }

        .inputbox input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            background-color: #4B49AC;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #3A3E99;
        }
    </style>
</head>
<body>
    <div class="container-scroller">
        <!-- Sidebar -->
        <nav class="sidebar">
            <h1>Connect Plus</h1>
            <ul>
                <li><a href="D:\xampp\htdocs\dolicha\view\back_office\dashboard.html">Dashboard</a></li>
                <li><a href="#dash">Forms</a></li>
                <li><a href="#das">Charts</a></li>
                <li><a href="#">User Management</a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="content-wrapper">
            <!-- Navbar -->
            <nav class="navbar">
                <div>
                    <input type="text" placeholder="Search user" style="padding: 8px 10px; border-radius: 4px; border: 1px solid #ddd;">
                </div>
                <div class="profile-info">
                    <img src="D:\xampp\htdocs\dolicha\view\back_office\assets\images\faces\face1.jpg" alt="Profile Picture"> <!-- Replace with actual image path -->
                    <span>Henry Klein</span>
                </div>
            </nav>

            <!-- Form for Editing User -->
            <div class="form-box">
                <h1>Modifier Utilisateur</h1>
                <?php if ($user): ?>
                    <form method="POST" action="../../../../controller/userController.php">
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" name="id_user" value="<?= htmlspecialchars($user['id_user']) ?>">

                        <div class="inputbox">
                            <label>Nom:</label>
                            <input type="text" name="Nom" value="<?= htmlspecialchars($user['nom']) ?>" required>
                        </div>

                        <div class="inputbox">
                            <label>Prénom:</label>
                            <input type="text" name="Prenom" value="<?= htmlspecialchars($user['prenom']) ?>" required>
                        </div>

                        <div class="inputbox">
                            <label>Email:</label>
                            <input type="email" name="usermail" value="<?= htmlspecialchars($user['usermail']) ?>" required>
                        </div>

                        <div class="inputbox">
                            <label>Rôle:</label>
                            <input type="text" name="userRole" value="<?= htmlspecialchars($user['userRole']) ?>" required>
                        </div>

                        <div class="inputbox">
                            <label>Adresse:</label>
                            <input type="text" name="adress" value="<?= htmlspecialchars($user['adress']) ?>" required>
                        </div>

                        <div class="inputbox">
                            <label>Nationalité:</label>
                            <input type="text" name="Nationalite" value="<?= htmlspecialchars($user['Nationalite']) ?>" required>
                        </div>

                        <div class="inputbox">
                            <label>Date de Naissance:</label>
                            <input type="date" name="ddn" value="<?= htmlspecialchars($user['ddn']) ?>" required>
                        </div>

                        <div class="inputbox">
                            <label>Numéro:</label>
                            <input type="text" name="num" value="<?= htmlspecialchars($user['num']) ?>" required>
                        </div>

                        <button type="submit">Enregistrer les modifications</button>
                    </form>
                <?php else: ?>
                    <p>Utilisateur introuvable.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Accueil</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('../front_office/img/ma.jpg') no-repeat center center/cover;
            color: white;
        }

        .container {
            background-color: rgba(0, 0, 0, 0.7); /* Fond transparent */
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        }

        h2 {
            margin-bottom: 10px;
        }

        p {
            margin-bottom: 20px;
        }

        .form-buttons {
            display: flex;
            justify-content: center;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            margin: 0 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Bienvenue sur notre site</h2>
        <p>Veuillez choisir une option</p>
        <div class="form-buttons">
            <!-- Redirection vers la page login.html -->
            <button onclick="window.location.href='login.html'">Se connecter</button>
            <!-- Redirection vers la page signup.html -->
            <button onclick="window.location.href='signup.php'">S'inscrire</button>
        </div>
    </div>
</body>
</html>

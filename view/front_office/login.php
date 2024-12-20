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
} 
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Glassmorphism Login Form</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    body {
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: url("img/av.jpg") no-repeat center center/cover;
      background-size: cover;
    }

    .form-box {
      position: relative;
      width: 400px;
      height: 450px;
      background: rgba(255, 255, 255, 0.1);
      border: 2px solid rgba(255, 255, 255, 0.5);
      border-radius: 20px;
      backdrop-filter: blur(15px);
      box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
    }

    h2 {
      font-size: 2em;
      color: #fff;
      text-align: center;
      margin-bottom: 20px;
    }

    .inputbox {
      position: relative;
      margin: 20px 0;
      width: 310px;
      border-bottom: 2px solid #fff;
    }

    .inputbox label {
      position: absolute;
      top: 50%;
      left: 5px;
      transform: translateY(-50%);
      color: #fff;
      font-size: 1em;
      pointer-events: none;
      transition: 0.5s;
    }

    input:focus ~ label, input:valid ~ label {
      top: -5px;
    }

    .inputbox input {
      width: 100%;
      height: 50px;
      background: transparent;
      border: none;
      outline: none;
      font-size: 1em;
      padding: 0 35px 0 5px;
      color: #fff;
    }

    .inputbox ion-icon {
      position: absolute;
      right: 8px;
      color: #fff;
      font-size: 1.2em;
      top: 20px;
    }

    .forget {
      display: flex;
      justify-content: space-between;
      margin: 10px 0 15px;
      font-size: 0.9em;
      color: #fff;
    }

    .forget label {
      display: flex;
      align-items: center;
    }

    .forget label input[type="checkbox"] {
      margin-right: 6px;
    }

    .forget label a {
      color: #fff;
      text-decoration: none;
    }

    .forget label a:hover {
      text-decoration: underline;
    }

    button {
      width: 100%;
      height: 40px;
      border-radius: 40px;
      background: #fff;
      border: none;
      outline: none;
      cursor: pointer;
      font-size: 1em;
      font-weight: 600;
      transition: background 0.3s ease;
    }

    button:hover {
      background: #ddd;
    }

    .register {
      font-size: 0.9em;
      color: #fff;
      text-align: center;
      margin: 25px 0 10px;
    }

    .register p a {
      text-decoration: none;
      color: #fff;
      font-weight: 600;
    }

    .register p a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
<section>
  <div class="form-box">
    <div class="form-value">
    <form id="loginForm" method="POST" action="login.php">
        <div class="inputbox">
          <ion-icon name="mail-outline"></ion-icon>
          <input type="email" id="usermail" name="usermail" required>
          <label>Email</label>
        </div>
        <div class="inputbox">
          <ion-icon name="lock-closed-outline"></ion-icon>
          <input type="password" id="password" name="password" required>
          <label>Password</label>
        </div>
        <div class="forget">
          <label>
            <input type="checkbox" name="remember"> Remember me
          </label>
          <label>
            <a href="">Forgot password?</a>
          </label>
        </div>
        <button type="submit" name="action" value="login">Log in</button>

        <div class="register">
          <p>Don't have an account? <a href="signup.php">Register</a></p>
        </div>
      </form>
    </div>
  </div>
</section>
<!-- Ionicons CDN -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Glassmorphism Sign Up Form</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    /* Glassmorphism Styles */
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
    }

    .form-box {
      position: relative;
      width: 400px;
      padding: 20px;
      background: rgba(255, 255, 255, 0.1);
      border: 2px solid rgba(255, 255, 255, 0.5);
      border-radius: 20px;
      backdrop-filter: blur(15px);
      box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
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
      width: 100%;
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

    input:focus ~ label, input:valid ~ label,
    select:focus ~ label, select:valid ~ label {
      top: -5px;
    }

    .inputbox input, .inputbox select {
      width: 100%;
      height: 50px;
      background: transparent;
      border: none;
      outline: none;
      font-size: 1em;
      padding: 0 5px;
      color: #fff;
    }

    .inputbox select {
      color: black;
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
      margin-top: 20px;
      transition: background 0.3s ease;
    }

    button:hover {
      background: #ddd;
    }

    .login {
      font-size: 0.9em;
      color: #fff;
      text-align: center;
      margin: 25px 0 10px;
    }

    .login p a {
      text-decoration: none;
      color: #fff;
      font-weight: 600;
    }

    .login p a:hover {
      text-decoration: underline;
    }
  </style>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
<section>
  <div class="form-box">
    <h2>Sign Up</h2>
    <form method="POST" action="../../controller/userController.php" onsubmit="return validateForm()">
      <input type="hidden" name="action" value="signup">

      <div class="inputbox">
        <input type="text" name="nom" id="nom" >
        <label for="nom">Nom</label>
      </div>

      <div class="inputbox">
        <input type="text" name="prenom" id="prenom">
        <label for="prenom">Prénom</label>
      </div>

      <div class="inputbox">
        <input type="email" name="usermail" id="usermail" >
        <label for="usermail">Email</label>
      </div>

      <div class="inputbox">
        <input type="password" name="password" id="password">
        <label for="password">Mot de passe</label>
      </div>

      <div class="inputbox">
        <input type="password" name="confirmPassword" id="confirmPassword" >
        <label for="confirmPassword">Confirmer le mot de passe</label>
      </div>

      <div class="inputbox">
        <select name="userRole" id="userRole">
          <option value="">-- Choisir un rôle --</option>
          <option value="admin">Admin</option>
          <option value="user">Utilisateur</option>
          <option value="vendeur">Vendeur</option>
        </select>
        <label for="userRole">Rôle</label>
      </div>

      <div class="inputbox">
        <input type="text" name="adress" id="adress" >
        <label for="adress">Adresse</label>
      </div>

      <div class="inputbox">
        <input type="text" name="Nationalite" id="Nationalite" >
        <label for="Nationalite">Nationalité</label>
      </div>

      <div class="inputbox">
        <input type="date" name="ddn" id="ddn" >
        <label for="ddn">Date de naissance</label>
      </div>

      <div class="inputbox">
        <input type="text" name="num" id="num" >
        <label for="num">Numéro de téléphone</label>
      </div>

      <div class="g-recaptcha" id="g-recaptcha" data-sitekey="6LcGKZoqAAAAAFreDYO5bBpz6w5huCbwr0t49s3F" data-callback="enableSubmitBtn"></div>

      <button type="submit" id="mySubmitBtn" name="btn" disabled>S'inscrire</button>

      <div class="login">
        <p>Already have an account? <a href="login.html">Log In</a></p>
      </div>
    </form>
  </div>
</section>
<script>
  // Activer le bouton submit une fois le reCAPTCHA validé
  function enableSubmitBtn() {
    document.getElementById("mySubmitBtn").disabled = false;
  }

  // Valider le formulaire
  function validateForm() {
    var nom = document.getElementById("nom").value.trim();
    var prenom = document.getElementById("prenom").value.trim();
    var email = document.getElementById("usermail").value.trim();
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirmPassword").value;
    var role = document.getElementById("userRole").value;
    var address = document.getElementById("adress").value.trim();
    var nationality = document.getElementById("Nationalite").value.trim();
    var birthDate = document.getElementById("ddn").value;
    var phone = document.getElementById("num").value.trim();
    var recaptchaResponse = document.getElementById("g-recaptcha-response").value;

    var errorMessage = "";
    var isValid = true;

    // Validation du champ Nom
    if (nom.length < 2) {
      errorMessage += "\u2022 Le champ Nom doit contenir au moins 2 caractères.\n";
      isValid = false;
    }

    // Validation du champ Prénom
    if (prenom.length < 2) {
      errorMessage += "\u2022 Le champ Prénom doit contenir au moins 2 caractères.\n";
      isValid = false;
    }

    // Validation de l'email
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
      errorMessage += "\u2022 Email invalide.\n";
      isValid = false;
    }

    // Validation du mot de passe
    if (password.length < 6) {
      errorMessage += "\u2022 Le mot de passe doit contenir au moins 6 caractères.\n";
      isValid = false;
    }
    if (password !== confirmPassword) {
      errorMessage += "\u2022 Les mots de passe ne correspondent pas.\n";
      isValid = false;
    }

    // Validation du rôle
    if (role === "") {
      errorMessage += "\u2022 Veuillez sélectionner un rôle.\n";
      isValid = false;
    }

    // Validation de l'adresse
    if (address.length < 3) {
      errorMessage += "\u2022 Adresse trop courte.\n";
      isValid = false;
    }

    // Validation de la nationalité
    if (nationality.length < 3) {
      errorMessage += "\u2022 Nationalité invalide.\n";
      isValid = false;
    }

    // Validation de la date de naissance
    if (!birthDate) {
      errorMessage += "\u2022 Entrez une date valide.\n";
      isValid = false;
    }

    // Validation du numéro de téléphone
    var phonePattern = /^[0-9]{8,}$/;
    if (!phonePattern.test(phone)) {
      errorMessage += "\u2022 Numéro de téléphone invalide (8 chiffres minimum).\n";
      isValid = false;
    }

    // Validation du reCAPTCHA
    if (!recaptchaResponse) {
      errorMessage += "\u2022 Veuillez vérifier le reCAPTCHA.\n";
      isValid = false;
    }

    // Affichage des erreurs
    if (!isValid) {
      alert("Corrigez les erreurs suivantes :\n" + errorMessage);
    }

    return isValid; // Empêche la soumission si des erreurs sont détectées
  }
</script>
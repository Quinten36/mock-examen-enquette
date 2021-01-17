<!-- <?php 
//controller eerst de verbinding
require 'config.inc.php';
require 'php/functions.php';
require 'php/logic.php'; 

function guidv4($data = null)
{
  $data = $data ?? random_bytes(16);
  setcookie('UUID4', $data, time() + (86400 * 30), "/");
  return $data;
}
// require_once 'session.inc.php';
?> -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GLR enquette</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
</head>
<body>
  <h1>GLR enquette site</h1>
  <div id="splashScreen">
    <div>
      <a href="#" id="signUpBtn">Sign up</a>
      <a href="#" id="loginBtn">Login in</a>
    </div>
  </div>
  <div id="formsScreen">
    <div>
      <form action="functions.php" method="post" id="signUpForm">
        <fieldset>
          <legend>Sign up</legend>
          <input type="hidden" id="uuid4" name="uuid4" value="<?php echo guidv4(); ?>">
          <label for="">Studentnummer: </label><input type="number" id="stNummerInput" placeholder="Vul hier uw studentnummer in">
          <label for="">Klas: </label><input type="text" id="klasInput" placeholder="Vul hier uw klas in">
          <label for="">Naam: </label><input type="text" id="naamInput" placeholder="Vul hier uw naam in">
          <label for="">Adres: </label><input type="text" id="adresInput" placeholder="Vul hier uw adres in">
          <label for="">Postcode: </label><input type="text" id="postcodeInput" placeholder="Vul hier uw postcode in">
          <label for="">Woonplaats: </label><input type="text" id="woonplaatsInput" placeholder="Vul hier uw woonplaats in">
          <label for="">Leeftijd: </label><input type="number" id="leeftijdInput" placeholder="Vul hier uw leeftijd in">
          <label for="">Email: </label><input type="email" id="emailInput" placeholder="Vul hier uw email in">
          <input type="submit" value="Verzenden" id="submitSignUp">
        </fieldset>
      </form>
      <div id="emailSendPopUp">
        <h3>Er is een email verstuurd naar: <span id="emailAdresSend"></span></h3>
        Hierin vindt u een link voor het afronden van de regisstratie
      </div>
    </div>
    <div>
      <form action="functions.php" method="post" id="loginForm">
        <fieldset>
          <legend>Login</legend>
            <input type="hidden" id="uuid4" name="uuid4" value="<?php echo guidv4(); ?>">
            <label for="emailInput">Email: </label><input type="text" id="emailInput">
            <label for="passwordInput">Password: </label><input type="password" id="passwordInput">
            <input type="submit" value="Verzenden" id="submitLogin">
        </fieldset>
      </form>
    </div>
    <a href="#" id="backBtn">Go back</a>
  </div>
  <script src="js/main.js"></script>
</body>
</html>
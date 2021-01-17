<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
?>
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
      <form action="" method="post" id="signUpForm">//functions.php?form=signUp
        <fieldset>
          <legend>Sign up</legend>
          <input type="hidden" id="uuid4" name="uuid4" value="<?php echo guidv4(); ?>">
          <label for="">Studentnummer: </label><input type="number" id="stNummerInput" name="studentnummer" placeholder="Vul hier uw studentnummer in">
          <label for="">Klas: </label><input type="text" id="klasInput" name="klas" placeholder="Vul hier uw klas in">
          <label for="">Naam: </label><input type="text" id="naamInput" name="naam" placeholder="Vul hier uw naam in">
          <label for="">Adres: </label><input type="text" id="adresInput" name="adres" placeholder="Vul hier uw adres in">
          <label for="">Postcode: </label><input type="text" id="postcodeInput" name="postcode" placeholder="Vul hier uw postcode in">
          <label for="">Woonplaats: </label><input type="text" id="woonplaatsInput" name="woonplaats" placeholder="Vul hier uw woonplaats in">
          <label for="">Leeftijd: </label><input type="number" id="leeftijdInput" name="leeftijd" placeholder="Vul hier uw leeftijd in">
          <label for="">Email: </label><input type="email" id="emailInput" name="email" placeholder="Vul hier uw email in">
          <input type="submit" value="Verzenden" id="submitSignUp" name="submitSignUp">
        </fieldset>
      </form>
      <div id="emailSendPopUp">
        <h3>Er is een email verstuurd naar: <span id="emailAdresSend"></span></h3>
        Hierin vindt u een link voor het afronden van de regisstratie
      </div>
    </div>
    <div>
      <form action="" method="post" id="loginForm">
        <fieldset>
          <legend>Login</legend>
            <input type="hidden" id="uuid4" name="uuid4" value="<?php echo guidv4(); ?>">
            <label for="emailInput">Email: </label><input type="text" id="emailInput">
            <label for="passwordInput">Password: </label><input type="password" id="passwordInput">
            <input type="submit" value="Verzenden" id="submitLogin" name="submitLogin">
        </fieldset>
      </form>
    </div>
    <a href="#" id="backBtn">Go back</a>
  </div>
  <script src="js/main.js"></script>
</body>
</html>
<?php
//sign Up
if(isset($_POST['submitSignUp'])){ //check if form was submitted
  //controle data
  $studentnummer  = $_POST['studentnummer'];
  $klas           = $_POST['klas'];
  $naam           = $_POST['naam'];
  $adres          = $_POST['adres'];
  $postcode       = $_POST['postcode'];
  $woonplaats     = $_POST['woonplaats'];
  $leeftijd       = $_POST['leeftijd'];
  $email          = $_POST['email'];
  if (strlen($studentnummer) > 0 &&
  strlen($klas) > 0 &&
  strlen($naam) > 0 &&
  strlen($adres) > 0 &&
  strlen($postcode) > 0 &&
  strlen($woonplaats) > 0 &&
  strlen($leeftijd) > 0 &&
  strlen($email) > 0)
// kijken of gegevens niet leeg zijn
{

}
else {
    $foutmelding = "";
    if (strlen($studentnummer) < 2) {
      $foutmelding .= "geen studentnummer ingevuld <br>";
    }
    else if (strlen($klas) < 2) {
      $foutmelding .= "geen klas ingevuld <br>";
    }
    else if (strlen($naam) < 0) {
      $foutmelding .= "geen naam ingevuld <br>";
    }
    else if (strlen($adres) < 0) {
      $foutmelding .= "geen adres ingevuld <br>";
    }
    else if (strlen($postcode) == 0) {
      $foutmelding .= "geen postcode ingevuld <br>";
    } 
    else if (strlen($woonplaats) < 0) {
      $foutmelding .= "geen woonplaats ingevuld <br>";
    }
    else if (strlen($leeftijd) < 0) {
      $foutmelding .= "geen leeftijd ingevuld <br>";
    }
    else if (strlen($email) == 0) {
      $foutmelding .= "geen email ingevuld <br>";
    }
      echo $foutmelding;
    }

  echo 'haai'; 
}    

//Log in
if(isset($_POST['submitLogin'])){ //check if form was submitted
  //controle data
  echo 'haai'; 
}   
?>

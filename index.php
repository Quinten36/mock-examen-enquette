<!DOCTYPE html>
<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//controller eerst de verbinding
require 'config.inc.php';
include('php/functions.php');
include 'php/logic.php'; 

if(isset($_GET['logout'])) {
  setcookie('uuid', null, 0, '/');    
  header('Location: index.php');
  exit;
}

// print_r(hash_algos());
// echo hash("sha3-256", "secret", FALSE);

function v4() {
  return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

    // 32 bits for "time_low"
    mt_rand(0, 0xffff), mt_rand(0, 0xffff),

    // 16 bits for "time_mid"
    mt_rand(0, 0xffff),

    // 16 bits for "time_hi_and_version",
    // four most significant bits holds version number 4
    mt_rand(0, 0x0fff) | 0x4000,

    // 16 bits, 8 bits for "clk_seq_hi_res",
    // 8 bits for "clk_seq_low",
    // two most significant bits holds zero and one for variant DCE1.1
    mt_rand(0, 0x3fff) | 0x8000,

    // 48 bits for "node"
    mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
  );
}

$uuid = v4();

// require_once 'session.inc.php';
?>
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
  <div id="redirectScreen">
    Pls check mail voor de link
    <br>
    or make new account <a href="?logout">here</a>
  </div>
  <div id="splashScreen">
    <div>
      <a href="#" id="signUpBtn">Sign up</a>
      <a href="#" id="loginBtn">Login in</a>
    </div>
  </div>
  <div id="formsScreen">
    <div>
      <form action="" method="post" id="signUpForm"><!--//functions.php?form=signUp-->
        <fieldset>
          <legend>Sign up</legend>
          <input type="hidden" id="uuid4" name="uuid4" value="<?php echo $uuid ?>">
          <label for="">Studentnummer: </label><input type="number" id="stNummerInput" name="studentnummer" placeholder="Vul hier uw studentnummer in"><br>
          <label for="">Klas: </label><input type="text" id="klasInput" name="klas" placeholder="Vul hier uw klas in"><br>
          <label for="">Naam: </label><input type="text" id="naamInput" name="naam" placeholder="Vul hier uw naam in"><br>
          <label for="">Adres: </label><input type="text" id="adresInput" name="adres" placeholder="Vul hier uw adres in"><br>
          <label for="">Postcode: </label><input type="text" id="postcodeInput" name="postcode" placeholder="Vul hier uw postcode in"><br>
          <label for="">Woonplaats: </label><input type="text" id="woonplaatsInput" name="woonplaats" placeholder="Vul hier uw woonplaats in"><br>
          <label for="">Leeftijd: </label><input type="number" id="leeftijdInput" name="leeftijd" placeholder="Vul hier uw leeftijd in"><br>
          <label for="">Email: </label><input type="email" id="emailInput" name="email" placeholder="Vul hier uw email in"><br>
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
            <input type="hidden" id="uuid4" name="uuid4" value="<?php echo $uuid; ?>">
            <label for="emailInput">Email: </label><input type="text" id="emailInput" name="email" placeholder="Vul hier uw email in">
            <label for="passwordInput">Password: </label><input type="password" id="passwordInput" name="password" placeholder="Vul hier uw password in">
            <input type="submit" value="Verzenden" id="submitLogin" name="submitLogin">
        </fieldset>
      </form>
    </div>
    <a href="#" id="backBtn">Go back</a>
  </div>
  <script src="js/main.js"></script>
  <script>
    myFunction();
  </script>
</body>
</html>
<?php
//sign Up
if(isset($_POST['submitSignUp'])){ 
  //controle data
  $uuid           = $_POST['uuid4'];
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
    $user = new registerProfile($uuid, $naam,$studentnummer,$klas,$adres,$postcode,$woonplaats,$leeftijd,$email);
    $user->mainHandler();
    $user->insertDB();
    //class function for pushing to DB
} else {
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
} else if(isset($_POST['submitLogin'])){ 
  //controle data
  $email          = $_POST['email'];
  $password       = $_POST['password'];
  if (strlen($email) > 0 && strlen($password) > 0) {
    $user = new loginHandler($email,$password);
    $user->loginCheck();
} else {
    $foutmelding = "";
    if (strlen($email) < 2) {
      $foutmelding .= "geen email ingevuld <br>";
    }
    else if (strlen($password) < 2) {
      $foutmelding .= "geen password ingevuld <br>";
    }
    echo $foutmelding;
  }
}

?>

<!DOCTYPE html>
<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//controller eerst de verbinding
require 'config.inc.php';
include('php/functions.php');
include 'php/logic.php'; 


//checken of je bent ingelogd
//checken welk level sec je heb
  //misschien preloader while level check?

if(!isset($_COOKIE['uuid'])) {
  header('Location: index.php');
  exit();
}

// $userCheck = new checker($_COOKIE['uuid']);
// $userCheck->userCheck();

if(isset($_GET['logout'])) {
  setcookie('uuid', null, 0, '/');    
  header('Location: index.php');
  exit;
}
?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/enquette.css">
  <link rel="stylesheet" href="css/modal.css">
  <title>Enquette</title>
</head>
<body>
<main id="student" class="hide">
  <h1>Dit is de enquette</h1>
  <button id="startEnquette">Start enquette</button>
  <button id="editEnquette">Wijzig enquette</button>
  <button id="profileBtn">Profiel</button>

  <div id="editProfile" class="hide">
    <h3>Wijzig profile</h3>
    <form action="">
      <fieldset>
        <legend>Wijzigen</legend>
        <label for="">Email</label><input type="text" name="" id="">
        <label for="">Nieuw password</label><input type="text" name="" id="">
        <label for="">Huldige password</label><input type="text" name="" id="">
      </fieldset>
    </form>
    <button id="returnEditProfile">Back</button>
  </div>

  <div id="enquetteForm" class="hide">
    <form action="" method="post">
      <fieldset>
        <legend>Enquette</legend>
        <label for="">Hoeveel kilometer woon je van het GLR?</label>
        <input type="number" name="travelDistance" required>
      <br>
        <label for="">Hoe lang doe je er over om van huis naar GLR te reizen?</label>
        <input type="number" name="travelTime" required>
      <br>
        <label for="">Welke voermiddel(en) gebruik je om naar het GLR te reizen?</label>
        <select id="travelMethods" name="travelMethods" required>
          <option value="none" disabled selected>Make a choice</option>
          <option value="train">Trein</option>
          <option value="tram">Tram</option>
          <option value="subway">Metro</option>
          <option value="bus">Bus</option>
          <option value="car">Auto</option>
          <option value="bike">Fiets</option>
          <option value="walk">Lopen</option>
        </select>
      <br>
        <label for="">Wat vind je van de begintijd van de lessen (8:15 uur)?</label>
        <select id="startTimeLessons" name="startTime" required>
          <option value="none" disabled selected>Make a choice</option>
          <option value="early">Te vroeg</option>
          <option value="good">Goed</option>
          <option value="late">Te laat</option>
        </select>
      <br>
        <label for="">Wat vind je van de eindtijd van de lessen (17:15 uur)?</label>
        <select id="endTimeLessons" name="endTime" required>
          <option value="none" disabled selected>Make a choice</option>
          <option value="early">Te vroeg</option>
          <option value="good">Goed</option>
          <option value="late">Te laat</option>
        </select>
      <br>
        <label for="">Heb je verder nog opmerkingen over het reizen naar het GLR?</label>
        <input type="text" name="travelComments">
      <br>
        <input type="submit" value="Verzenden" id="submitEnquette" name="submitEnquette">
      </fieldset>
    </form>
  </div>

  <div id="editEnquetteForm" class="hide">
    <form action="" method="post">
      <fieldset>
        <legend>Wijzig enquette</legend>
        <label for="">Hoeveel kilometer woon je van het GLR?</label>
        <input type="number" name="travelDistance" id="travelDistance" required>
      <br>
        <label for="">Hoe lang doe je er over om van huis naar GLR te reizen?</label>
        <input type="number" name="travelTime" id="travelTime" required>
      <br>
        <label for="">Welke voermiddel(en) gebruik je om naar het GLR te reizen?</label>
        <select id="travelMethods" name="travelMethods" required>
          <option value="none" disabled selected>Make a choice</option>
          <option value="train">Trein</option>
          <option value="tram">Tram</option>
          <option value="subway">Metro</option>
          <option value="bus">Bus</option>
          <option value="car">Auto</option>
          <option value="bike">Fiets</option>
          <option value="walk">Lopen</option>
        </select>
      <br>
        <label for="">Wat vind je van de begintijd van de lessen (8:15 uur)?</label>
        <select id="startTimeLessons" name="startTime" required>
          <option value="none" disabled selected>Make a choice</option>
          <option value="early">Te vroeg</option>
          <option value="good">Goed</option>
          <option value="late">Te laat</option>
        </select>
      <br>
        <label for="">Wat vind je van de eindtijd van de lessen (17:15 uur)?</label>
        <select id="endTimeLessons" name="endTime" required>
          <option value="none" disabled selected>Make a choice</option>
          <option value="early">Te vroeg</option>
          <option value="good">Goed</option>
          <option value="late">Te laat</option>
        </select>
      <br>
        <label for="">Heb je verder nog opmerkingen over het reizen naar het GLR?</label>
        <input type="text" name="travelComments" id="travelComments">
      <br>
        <input type="submit" value="Verzenden" id="submitEditedEnquette" name="submitEditedEnquette">
      </fieldset>
    </form>
  </div>
</main>
<main id="teacher" class="hide">
  <h1>Teacher senpai</h1>
  <!-- table -->
  <table id="enquetteOverview">
    <thead>
      <tr>
        <th class="hide"></th>
        <th>Student</th>
        <th>travelDistance</th>
        <th>TravelTime</th>
        <th>travelMethods</th>
        <th>StartTime</th>
        <th>endTime</th>
        <th>travelComments</th>
        <th>Signed</th>
      </tr>
    </thead>
    <tbody>
      <!-- content form javascript -->
    </tbody>
  </table>

  <div id="studentProfileModal" class="hide">
    <div class="content">
      <button>X</button>
      <h2>Name</h2>
      <table>
        <thead>
          <tr>
            <th>student nummer</th>
            <th>klas</th>
            <th>adres</th>
            <th>postcode</th>
            <th>woonplaats</th>
            <th>leeftijd</th>
          </tr>
        </thead>
        <tbody>
          <!-- content form javascript -->
        </tbody>
      </table>
    </div>
  </div>
</main>
  <a href="?logout">uitloggen</a>
  <script src="js/main.js"></script>
  <script src="js/enquette.js"></script>
  <script src="js/modal.js"></script>
</body>
</html>
<?php

$checker = new checker($_COOKIE['uuid']);
$checker->userLevel($_COOKIE['uuid']);
$checker->enquetteFilledIn();

//filled in enquette
if(isset($_POST['submitEnquette'])){ 
  //controle data
  $foutmelding = "";

  $travelDistance   = $_POST['travelDistance'];//number
  $travelTime       = $_POST['travelTime'];//number
  $travelMethods    = $_POST['travelMethods'];//multi choice
  $startTime        = $_POST['startTime'];//choice
  $endTime          = $_POST['endTime'];//choice
  $travelComments   = $_POST['travelComments'];//text
  if (strlen($travelDistance) > 0 && strlen($travelTime) > 0 && $travelMethods != NULL && $startTime != NULL && $endTime != NULL) { 


    
    // kijken of gegevens niet leeg zijn
    //check if choice where made right?
    $uuid = $_COOKIE['uuid'];
    $enquette = new enquetteHandler($uuid, $travelDistance, $travelTime, $travelMethods, $startTime, $endTime, $travelComments);
    $enquette->mainHandler();
    
  } else {
    if (strlen($travelDistance) < 0) {
      $foutmelding .= "geen reis afstand ingevuld <br>";
    } else if (strlen($travelTime) < 0) {
      $foutmelding .= "geen reis tijd ingevuld <br>";
    } else if ($travelMethods == NULL) {
      $foutmelding .= "kies een vervoermiddel <br>";
    } else if ($startTime == NULL) {
      $foutmelding .= "kies een start tijd <br>";
    } else if ($endTime == NULL) {
      $foutmelding .= "kies een eind tijd <br>";
    }
    echo $foutmelding;
  }
//edited enquette
}
if(isset($_POST['submitEditedEnquette'])) {
  $foutmelding = "";

  $travelDistance   = $_POST['travelDistance'];//number
  $travelTime       = $_POST['travelTime'];//number
  $travelMethods    = $_POST['travelMethods'];//multi choice
  $startTime        = $_POST['startTime'];//choice
  $endTime          = $_POST['endTime'];//choice
  $travelComments   = $_POST['travelComments'];//text
  if (strlen($travelDistance) > 0 && strlen($travelTime) > 0 && $travelMethods != NULL && $startTime != NULL && $endTime != NULL) { 

    $uuid = $_COOKIE['uuid'];


    $enquette = new enquetteHandler($uuid, $travelDistance, $travelTime, $travelMethods, $startTime, $endTime, $travelComments);
    $enquette->insertEditEnquette();
    
  } else {
    if (strlen($travelDistance) < 0) {
      $foutmelding .= "geen reis afstand ingevuld <br>";
    } else if (strlen($travelTime) < 0) {
      $foutmelding .= "geen reis tijd ingevuld <br>";
    } else if ($travelMethods == NULL) {
      $foutmelding .= "kies een vervoermiddel <br>";
    } else if ($startTime == NULL) {
      $foutmelding .= "kies een start tijd <br>";
    } else if ($endTime == NULL) {
      $foutmelding .= "kies een eind tijd <br>";
    }
    echo $foutmelding;
  }
}
?>
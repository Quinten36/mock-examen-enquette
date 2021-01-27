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
  <title>Enquette</title>
</head>
<body>
  <h1>Dit is de enquette</h1>
  <button id="profileBtn">Profile</button>
  <div>
    <h3>Edit profile</h3>
    <form action="">
      <fieldset>
        <legend>Edit</legend>
        <label for="">Email</label><input type="text" name="" id="">
        <label for="">New password</label><input type="text" name="" id="">
        <label for="">Current password</label><input type="text" name="" id="">
      </fieldset>
    </form>
    username: <input type="text" value="van PHP">
    new password: <input type="text" value="van PHP">
    current password: <input type="password">
  </div>

  <a href="?logout">logout</a>
  <script src="js/main.js"></script>
</body>
</html>
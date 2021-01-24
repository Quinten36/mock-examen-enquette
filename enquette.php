<?php 
//checken of je bent ingelogd
//checken welk level sec je heb
  //misschien preloader while level check?




  if(isset($_GET['logout'])) {
    setcookie('uuid', null, 0, '/');    
    header('Location: index.php');
    exit;
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Enquette</title>
</head>
<body>
  <h1>Dit is de enquette</h1>
  <a href="?logout">logout</a>
</body>
</html>
<?php

require 'config.inc.php';
require 'php/logic.php';

$dbh = new Dbh;
$pdo = $dbh->connect();

// $q = $_REQUEST["q"];

$action = "";

if (isset($_POST['_action']) && isset($_POST['_what'])) {
  switch ($_POST['_action']) {
    case 'get':
      switch ($_POST['_what']) {
        case 'getEnquette':

          $output['status'] = '-';
          
          $uuid = $_COOKIE['uuid'];

          $prep = "SELECT * FROM `mock-exam-answer` WHERE `uuid` = (:uuid)";
          $stmt = $pdo->prepare($prep);
          $stmt->bindParam(':uuid', $uuid);

          if ($stmt->execute()) {
            $output['status'] = 'ok';
            $output['response'] = $stmt->fetch();
          }
          echo json_encode($output);
          die();
        break;

        case 'getStudentProfile':

          $output['status'] = '-';

          $uuid = $_POST['_uuid'];

          $prep = "SELECT * FROM `mock-exam-user` WHERE `uuid` = (:uuid)";
          $stmt = $pdo->prepare($prep);
          $stmt->bindParam(':uuid', $uuid);

          if ($stmt->execute()) {
            $output['status'] = 'ok';
            $output['response'] = $stmt->fetch();
          }

          echo json_encode($output);
          die();
          
        break;

        default:
        break;
      }
      break;
    
    case 'interactive':
    break;

    default:
    break;
  }
}

// if ($q !== "") {
//   switch ($q) {
//     case 'editEnquette':
//       // $dev1 = new dev('dev1');
//       $output['status'] = 'failed';










      
//       $uuid = $_COOKIE['uuid'];
//       // var_dump($_COOKIE['uuid']);
//       // echo json_encode($_COOKIE['uuid']);


//       $overview = new fetchEnquette();
//       $overview->fetchEnquette($uuid);
//        echo json_encode($overview);

//       //call to logic.php
//       //right class
//       //send al data in json format to js


//       $action .= "edit";//$dev1->output()
//       break;
    
//     default:
//       # code...
//       break;
//   }

// }

// echo $action === "" ? "default" : $action;
?>
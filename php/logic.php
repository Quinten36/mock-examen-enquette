<?php
require "PHPMailer/PHPMailerAutoload.php";
require 'envHandler.php';

$env = new DotEnv(__DIR__ . '/../.env');
$env->load();

// echo (extension_loaded('openssl')?'':'SSL not loaded');


class registerProfile {
//uuid?
  private $uuid;
  public $name;
  public $stNummer;
  public $klas;
  public $adres;
  public $postcode;
  public $woonplaats;
  public $leeftijd;
  public $email;
  private $password;
  protected $Bpass;
  protected $pdo;

  function __construct($_uuid, $_name, $_stNummer, $_klas, $_adres, $_postcode, $_woonplaats, $_leeftijd, $_email) {
    $this->uuid = $_uuid;
    $this->name = $_name;
    $this->stNummer = $_stNummer;
    $this->klas = $_klas;
    $this->adres = $_adres;
    $this->postcode = $_postcode;
    $this->woonplaats = $_woonplaats;
    $this->leeftijd = $_leeftijd;
    $this->email = $_email;
    $dbh = new Dbh;
    $pdo = $dbh->connect();
    $this->pdo = $pdo;
    $this->Bpass = $this->randomPassword();
    $this->password = hash("sha3-256", $this->Bpass, FALSE);
  }

  function smtpmailer($to, $from, $from_name, $subject, $body)
  {
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPDebug = 0;
    $mail->Debugoutput = 'html';
    $mail->SMTPAuth = true; 

    $mail->SMTPSecure = 'tls'; 
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;  
    $mail->Username = 'qkempers36@gmail.com';
    $mail->Password = getenv('MAILERPW');   

    $mail->IsHTML(true);
    $mail->From="qkempers36@gmail.com";
    $mail->FromName=$from_name;
    $mail->Sender=$from;
    $mail->AddReplyTo($from, $from_name);
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->AddAddress($to);
    if(!$mail->Send())
    {
      $error ="Please try Later, Error Occured while Processing...";
      // var_dump($mail);
      return $error; 
    }
    else 
    {
      $error = "Thanks You !! Your email is sent.";  
      // return $error;
    }
  }

  function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode('',$pass); //turn the array into a string
  }

  function mainHandler() {
    $to   = $this->email;
    $from = 'qkempers36@gmail.com';
    $name = 'Quinten Kempers';
    $subj = 'Bedankt voor het registeren';
    //random password gen
   
    $msg = 'Hallo '.$this->name.',<br><br>Bedankt voor het registeren en hierbij ontvangt u ook uw wachtwoord. Deze kunt in de profile settings veranderen.<br>Wachtwoord: '.$this->Bpass.'<br><br>Klik <a href="https://83502.ict-lab.nl/mock-examen-enquette/enquette.php">hier</a> om regisstratie af te ronden<br><br>Met vriendelijke groet,<br><br>Quinten Kempers';
    
    $error=$this->smtpmailer($to,$from, $name ,$subj, $msg);
    echo $error;
  } 

  function insertDB() {
    $prep = "INSERT INTO `mock-exam-user` (`uuid`, `name`, `stNummer`, `klas`, `adres`, `postcode`, `woonplaats`, `leeftijd`, `email`) 
    VALUES ((:uuid),(:name),(:stNummer),(:klas),(:adres),(:postcode),(:woonplaats),(:leeftijd),(:email))";
    // $prep = "SELECT * FROM `veipro` WHERE `name` = (:username) AND `password` = (:password)";
    $stmt = $this->pdo->prepare($prep);
    $stmt->bindParam(':uuid', $this->uuid);
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':stNummer', $this->stNummer);
    $stmt->bindParam(':klas', $this->klas);
    $stmt->bindParam(':adres', $this->adres);
    $stmt->bindParam(':postcode', $this->postcode);
    $stmt->bindParam(':woonplaats', $this->woonplaats);
    $stmt->bindParam(':leeftijd', $this->leeftijd);
    $stmt->bindParam(':email', $this->email);

    $prep2 = "INSERT INTO `mock-exam-login` (`uuid`, `email`, `password`, `level`) 
    VALUES ((:uuid),(:email),(:password),0)";
    $stmt2 = $this->pdo->prepare($prep2);
    $stmt2->bindParam(':uuid', $this->uuid);
    $stmt2->bindParam(':email', $this->email);
    $stmt2->bindParam(':password', $this->password);
    // $stmt2->execute();
    if ($stmt2->execute()) {
      if ($stmt->execute()) {
        setcookie('uuid', $this->uuid, time() + (86400 * 30), "/"); // 86400 = 1 day
        // echo 'inserted';
      } else {
        echo 'first fail';
      }
    } else {
      echo 'second fail';
    }
  }
  
}

//class voor login

class loginHandler {
  private $uuid;
  public $email;
  private $password;
  protected $pdo;

  function __construct($_email, $_password) {
    $this->email = $_email;
    $this->password = hash("sha3-256", $_password, FALSE);
    $dbh = new Dbh;
    $pdo = $dbh->connect();
    $this->pdo = $pdo;
  }

  function loginCheck() {
    //haal gegevens op
    //kijk of username bestaat
    //kijk bij die username het password
    //encrypten?
    $foutmelding = "";

    $prep = "SELECT `uuid`, `email`, `password`, `level` FROM `mock-exam-login` WHERE `email` = (:email)";
    $stmt = $this->pdo->prepare($prep);
    $stmt->bindParam('email', $this->email);
    $stmt->execute();
    $res = $stmt->fetch();
    var_dump($res);
    if ($res['email'] == $this->email) {
      if ($res['password'] == $this->password) {
        //redirect naar enquette site
        setcookie('uuid', $res['uuid'], time() + (86400 * 30), "/"); // 86400 = 1 day
        setcookie('level', $res['level'], time() + (86400 * 30), "/");
        header('Location: enquette.php', true, 303);
        // echo 'login done';
      } else {
        $foutmelding .= $this->password;
        var_dump($this->password.' password');
        $foutmelding .= '<br>'.$res['password'];
        $foutmelding .= " geen gelding wachtwoord ingevuld";
      }
    } else {
      
      $foutmelding .= "geen geldig email ingevuld";
    }
    echo '<br>'.$foutmelding;
  }
}

class enquetteHandler {
  protected $uuid;
  private $travelDistance;
  private $travelTime;
  private $travelMethods;
  private $startTime;
  private $endTime;
  private $travelComments;
  protected $pdo;

  function __construct($_uuid, $_travelDistance, $_travelTime, $_travelMethods, $_startTime, $_endTime, $_travelComments = '') {
    $this->uuid = $this->clean($_uuid);
    $this->travelDistance = $this->clean($_travelDistance);
    $this->travelTime = $this->clean($_travelTime);
    $this->travelMethods = $this->clean($_travelMethods);
    $this->startTime = $this->clean($_startTime);
    $this->endTime = $this->clean($_endTime);
    $this->travelComments = $this->clean($_travelComments);
    $dbh = new Dbh;
    $pdo = $dbh->connect();
    $this->pdo = $pdo;
  }

  function clean($string) {
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
 }

  function insertDB() {
    $prep = "INSERT INTO `mock-exam-answer` (`uuid`, `travelDistance`, `travelTime`, `travelMethods`, `startTime`, `endTime`, `travelComments`) 
    VALUES ((:uuid),(:travelDistance),(:travelTime),(:travelMethods),(:startTime),(:endTime),(:travelComments))";
    $stmt = $this->pdo->prepare($prep);
    $stmt->bindParam(':uuid', $this->uuid);
    $stmt->bindParam(':travelDistance', $this->travelDistance);
    $stmt->bindParam(':travelTime', $this->travelTime);
    $stmt->bindParam(':travelMethods', $this->travelMethods);
    $stmt->bindParam(':startTime', $this->startTime);
    $stmt->bindParam(':endTime', $this->endTime);
    $stmt->bindParam(':travelComments', $this->travelComments);

    if ($stmt->execute()) {
      
      echo 'inserted';
    } else {
      echo 'first fail';
    }
  }

  function insertEditEnquette() {
    $prep = "UPDATE `mock-exam-answer` SET `travelDistance`=(:travelDistance),`travelTime`=(:travelTime),`travelMethods`=(:travelMethods),`startTime`=(:startTime),`endTime`=(:endTime),`travelComments`=(:travelComments) 
    WHERE `uuid` = (:uuid)";
    $stmt = $this->pdo->prepare($prep);
    $stmt->bindParam(':travelDistance', $this->travelDistance);
    $stmt->bindParam(':travelTime', $this->travelTime);
    $stmt->bindParam(':travelMethods', $this->travelMethods);
    $stmt->bindParam(':startTime', $this->startTime);
    $stmt->bindParam(':endTime', $this->endTime);
    $stmt->bindParam(':travelComments', $this->travelComments);
    $stmt->bindParam(':uuid', $this->uuid);

    if ($stmt->execute()) {
      echo 'inserted';
    } else {
      echo 'first fail';
    }
  }

  function mainHandler() {
    //check vars again
    //send to DB function
    $this->insertDB();
  }

}

class checker {
  private $uuid;
  private $level;
  function __construct($__uuid) {
    $this->uuid = $__uuid;
    $dbh = new Dbh;
    $pdo = $dbh->connect();
    $this->pdo = $pdo;
  }

  function enquetteFilledIn() {
    $prep = "SELECT `uuid` FROM `mock-exam-answer` WHERE `uuid` = (:uuid)";
    $stmt = $this->pdo->prepare($prep);
    $stmt->bindParam(':uuid', $this->uuid);
    $stmt->execute();
    $res = $stmt->fetch();

    if (strlen($res['uuid']) > 30) {
      echo '<script type="text/javascript"> hideStartEnquette();</script>';
    } else {
      echo '<script type="text/javascript"> hideEditEnquette();</script>';
    }
  }

  function userCheck() {
    if ($this->level < 5) {
      $prep = "SELECT `uuid` FROM `mock-exam-answer` WHERE `uuid` = (:uuid)";
      $stmt = $this->pdo->prepare($prep);
      $stmt->bindParam(':uuid', $this->uuid);
      $stmt->execute();
      $res = $stmt->fetch();
      var_dump(strlen($res['uuid']));

      if (strlen($res['uuid']) > 30) {
        //echo '<script type="text/javascript"> hideStartEnquette();</script>';
      } else {
        // header('Location: index.php');
        // exit();
        //echo '<script type="text/javascript"> hideEditEnquette();</script>';
      }
    }
  }

  function fetchEnquettes($klas) {
    $prep = "SELECT A.uuid, A.travelDistance, A.travelTime, A.travelMethods, A.startTime, A.endTime, A.travelComments, A.lastEdited, U.klas, U.name FROM `mock-exam-answer` as A INNER JOIN `mock-exam-user` as U ON A.uuid=U.uuid AND U.klas=(:klas)"; 
    $stmt = $this->pdo->prepare($prep);
    $stmt->bindParam(':klas', $klas);
    $stmt->execute();
    $res = $stmt->fetchAll();
    // var_dump($res);

    if (count($res) > 0) {
      foreach ($res as $student) {
        // var_dump($student);
        echo '<script type="text/javascript"> displayEnquette('.json_encode($student).');</script>';
      }
    }
  }

  function userLevel($uuid) {
    // $prep = "SELECT `level` FROM `mock-exam-login` WHERE `uuid` = (:uuid)";
    $prep = "SELECT L.level, U.klas FROM `mock-exam-login` as L INNER JOIN `mock-exam-user` as U ON L.uuid = U.uuid AND U.uuid = (:uuid)"; 
    $stmt = $this->pdo->prepare($prep);
    $stmt->bindParam(':uuid', $this->uuid);
    $stmt->execute();
    $res = $stmt->fetch();

    if ($res['level'] > 0) {
      // echo $res['level'];
      $this->level = $res['level'];
      $this->fetchEnquettes($res['klas']);
      echo '<script type="text/javascript"> showTeacher();</script>';
    } else {
      echo '<script type="text/javascript"> showStudent();</script>';
    }
  }
}

class fetchEnquette {
  //on student overview show head of enquette. if the enquette is inserted
  function __construct() {
    $dbh = new Dbh;
    $pdo = $dbh->connect();
    $this->pdo = $pdo;
  }

  public static function fetchE() {
    echo 'haai';
    return 'haai';
  }
}

class dev {
  public $dev;
  function __construct($__begin) {
    $this->dev = $__begin;
    $this->output();
  }

  function output() {
    return 'edit';
  }
}
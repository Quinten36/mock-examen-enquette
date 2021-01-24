<?php
require "PHPMailer/PHPMailerAutoload.php";
require 'envHandler.php';

$env = new DotEnv(__DIR__ . '/../.env');
$env->load();

echo (extension_loaded('openssl')?'SSL loaded':'SSL not loaded')."\n";


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
    $this->password = $this->randomPassword();
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
      return $error;
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
    $subj = 'PHPMailer 5.2 testing from DomainRacer';
    //random password gen
   
    $msg = 'This is mail about testing mailing using PHP.\n Your password is: '. $this->password;
    
    $error=$this->smtpmailer($to,$from, $name ,$subj, $msg);
    echo $error;
  } 

  function insertDB() {
    $prep = "INSERT INTO `mock-exam` (`uuid`, `name`, `stNummer`, `klas`, `adres`, `postcode`, `woonplaats`, `leeftijd`, `email`) 
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
    // $stmt->bindParam(':password', $this->password);
    // $stmt->execute();

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
        echo 'inserted';
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

  function __construct($_uuid, $_email, $_password) {
    $this->uuid = $_uuid;
    $this->email = $_email;
    $this->password = $_password;
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
    if ($res['email'] == $this->email) {
      if ($res['password'] == $this->password) {
        //redirect naar enquette site
        setcookie('uuid', $this->uuid, time() + (86400 * 30), "/"); // 86400 = 1 day
        header('Location: enquette.php', true, 303);
        echo 'login done';
      } else {
        $foutmelding .= "geen gelding wachtwoord ingevuld";
      }
    } else {
      $foutmelding .= "geen geldig email ingevuld";
    }
    echo '\n<br>'.$foutmelding;
  }
}
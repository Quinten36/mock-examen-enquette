<?php

class formValueCheck {
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
  private $pdo;

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
  }

  //funcion voor controle UUID
  function insertDB() {
    // $prep = "INSERT INTO `mock-exam`(`uuid`, `name`, `stNummer`, `klas`, `adres`, `postcode`, `woonplaats`, `leeftijd`, `email`) 
    // VALUES ((:uuid),(:name),(:stNummer),(:klas),(:adres),(:postcode),(:woonplaats),(:leeftijd),(:email))";
    // // $prep = "SELECT * FROM `veipro` WHERE `name` = (:username) AND `password` = (:password)";
    // $stmt = $this->pdo->prepare($prep);
    // $stmt->bindParam(':uuid', $verifiedName);
    // $stmt->bindParam(':name', $verifiedPassword);
    // $stmt->bindParam(':stNummer', $verifiedName);
    // $stmt->bindParam(':klas', $verifiedPassword);
    // $stmt->bindParam(':adres', $verifiedName);
    // $stmt->bindParam(':postcode', $verifiedPassword);
    // $stmt->bindParam(':woonplaats', $verifiedName);
    // $stmt->bindParam(':leeftijd', $verifiedPassword);
    // $stmt->bindParam(':email', $verifiedPassword);
    // $stmt->execute();
  }

  function mailSend() {
    // $to = "q.kempers@outlook.com, qkempers36@gmail.com";
    // $subject = "HTML email";

    // $message = "
    // <html>
    // <head>
    // <title>HTML email</title>
    // </head>
    // <body>
    // <p>This email contains HTML Tags!</p>
    // <table>
    // <tr>
    // <th>Firstname</th>
    // <th>Lastname</th>
    // </tr>
    // <tr>
    // <td>John</td>
    // <td>Doe</td>
    // </tr>
    // </table>
    // </body>
    // </html>
    // ";

    // // Always set content-type when sending HTML email
    // $headers = "MIME-Version: 1.0" . "\r\n";
    // $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // // More headers
    // $headers .= 'From: <webmaster@example.com>' . "\r\n";
    // $headers .= 'Cc: 83502@glr.nl' . "\r\n";

    // mail($to,$subject,$message,$headers);
  }
  
}

//class voor login
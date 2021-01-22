<?php
require "PHPMailer/PHPMailerAutoload.php";
require 'envHandler.php';

$env = new DotEnv(__DIR__ . '/.env');
$env->load();

// use DevCoder\DotEnv;
// (new DotEnv(__DIR__ . '/.env'))->load();

echo (extension_loaded('openssl')?'SSL loaded':'SSL not loaded')."\n";

function smtpmailer($to, $from, $from_name, $subject, $body)
    {
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug = 3;
        $mail->Debugoutput = 'html';
        $mail->SMTPAuth = true; 
 
        $mail->SMTPSecure = 'tls'; 
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;  
        $mail->Username = 'qkempers36@gmail.com';
        $mail->Password = getenv('MAILERPW');   
   
   //   $path = 'reseller.pdf';
   //   $mail->AddAttachment($path);
   
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
    
    $to   = '83502@glr.nl';
    $from = 'qkempers36@gmail.com';
    $name = 'Quinten Kempers';
    $subj = 'PHPMailer 5.2 testing from DomainRacer';
    $msg = 'This is mail about testing mailing using PHP.';
    
    $error=smtpmailer($to,$from, $name ,$subj, $msg);
    
?>

<html>
    <head>
        <title>PHPMailer 5.2 testing from DomainRacer</title>
    </head>
    <body>
        <center><h2 style="padding-top:70px;color: white;"><?php echo $error; ?></h2></center>
    </body>
    
</html>
<?php

require 'phpMailer/PHPMailer.php';
require 'phpMailer/SMTP.php';
require 'phpMailer/Exception.php';
$data = require_once 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

//Create instance of PHPMAILER
$mail = new PHPMailer();
//Set mailer to use SMTP PORT
$mail->isSMTP();
//define host
$mail->Host = "smtp.gmail.com";
//enable smtp authentification
$mail->SMTPAuth = "true";
//set type of encryption (ssl/tls)
$mail->SMTPSecure = "tls";
//set connection port
$mail->Port = "587";
//set gmail username
$mail->Username =  $data['mail']['username'];
//set gmail password
$mail->Password =  $data['mail']['password'];
// write subject
$mail->Subject = "Lab_2 send an email";
//set sender email
$mail->setFrom("z61149036@gmail.com");
//Content of message
$mail->Body = "Hello world";
//Set recipient
$mail->addAddress("z61149036@gmail.com");
//send email
if($mail->Send()){
    echo "Succeful email was sended";
}
else{
    echo "Something is wrong "; 
}
//close smtp connection
$mail->smtpClose();
?>
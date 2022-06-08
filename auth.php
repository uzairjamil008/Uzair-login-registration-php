<?php
require('config.php');

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendmail($email, $v_code)
{
//Create an instance; passing `true` enables exceptions
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';
$mail = new PHPMailer(true);

try {
    //Server settings  
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.mailtrap.io';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'a3ef97162dbf90';                     //SMTP username
    $mail->Password   = 'ac9a5610d4a8c0';                               //SMTP password
    $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
    $mail->Port       = 2525;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('muhammadyousaf926363@gmail.com', 'uzair');
    $mail->addAddress($email);     //Add a recipient


    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Email Verfication System from Uzair';
    $mail->Body    = "Click here to verify your email<a href='http://localhost/loginsystem/verify.php?email=$email&vcode=$v_code'>Verify</a>";

    $mail->send();
    return true;
} 
catch (Exception $e) 
{
    // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    return false;
}
}
?>
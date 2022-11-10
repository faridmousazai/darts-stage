<?php

require "vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

$name = $_POST["name"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$message = $_POST["message"];

$mail = new PHPMailer(true);

$mail->SMTPDebug = SMTP::DEBUG_SERVER;

$mail->isSMTP();
$mail->SMTPAuth = true;

$mail->Host = "localhost";
// $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
// $mail->SMTPAutoTLS = false;
// $mail->SMTPSecure = CURL_SSLVERSION_SSLv2;
$mail->Port = 2525;

// $mail->Username = "fkluckykhan1@gmail.com";
// $mail->Password = "kesbkttipuisvenj";

$mail->setFrom($email, $name);
$mail->addAddress("fkluckykhan1@gmail.com");

$mail->Subject = "New message";
$mail->Body = $message;

$mail->send();

header("Location: sent.html");

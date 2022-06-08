<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require_once __DIR__ . "/app/bootstrap.php";


$mail = new PHPMailer();
$mail->isSMTP();

$mail->SMTPDebug = SMTP::DEBUG_SERVER;

//Set the hostname of the mail server
$mail->Host = 'smtp.gmail.com';

//Set the SMTP port number:
$mail->Port = 465;

//Set the encryption mechanism to use:
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

//Whether to use SMTP authentication
$mail->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = 'restaurantcis1054@gmail.com';

//Password to use for SMTP authentication
$mail->Password = 'CIS1054!@';

//Set who the message is to be sent from
$mail->setFrom('restaurantcis1054@gmail.com', 'Restaurant');
//Set who the message is to be sent to
$mail->addAddress($_POST['email'], $_POST['name']);
//Set the subject line
$mail->Subject = 'Favourites List';

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML(file_get_contents('contents.html'), __DIR__);

//send the message, check for errors
if (!$mail->send()) {
    echo 'Oh no! We have an error: ' . $mail->ErrorInfo;
} else {
    echo 'Check your mail box!';
}
?>

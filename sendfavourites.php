<?php

require_once __DIR__ . "/app/bootstrap.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (empty($_POST['email']) || empty($_POST['full_name'])) {
        exit('Email and Name are required');
    }

    $email = clean_input($_POST['email']);
    $full_name = clean_input($_POST['full_name']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        exit("Invalid email");
    }

    $to = $email;
    $subject = "Restaurant - Favourite list";

    $message = file_get_contents(\App\FavouriteList::generateFile());

    $header = "From:restaurant@localhost \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    $retVal = mail($to,$subject,$message,$header);

    if($retVal === true) {
        $msg = "Favourite list sent successfully...<br>";
        $msg .= "<a href='/'>Return home</a>";
        exit($msg);
    }

    $msg = "Message could not be sent...<br>";
    $msg .= "<a href='/'>Return home</a>";
    exit($msg);
}

exit($twig->render('404.twig'));
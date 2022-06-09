<?php

require_once __DIR__ . "/app/bootstrap.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (
        empty($_POST['full_name']) ||
        empty($_POST['email']) ||
        empty($_POST['phone']) ||
        empty($_POST['date']) ||
        empty($_POST['time'])
    ) {
        exit($twig->render('mail.twig', [
            'title' => 'Reservation failed.',
            'message' => 'All fields are required.'
        ]));
    }

    $full_name = clean_input($_POST['full_name']);
    $email = clean_input($_POST['email']);
    $phone = clean_input($_POST['phone']);
    $date = clean_input($_POST['date']);
    $time = clean_input($_POST['time']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        exit($twig->render('mail.twig', [
            'title' => 'Reservation failed.',
            'message' => 'Invalid email.'
        ]));
    }

    $to = $email;
    $subject = "Restaurant - Favourite list";

    $message = file_get_contents(\App\FavouriteList::generateFile());

    $header = "From:restaurant@localhost \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    $retVal = mail($to,$subject,$message,$header);

    if($retVal === true) {
        exit($twig->render('mail.twig', [
            'title' => 'Reservation successfully created!',
            'message' => 'Check your email box.'
        ]));
    }

    exit($twig->render('mail.twig', [
        'title' => 'Reservation failed.',
        'message' => 'Unknown error occurred.'
    ]));
}

exit($twig->render('404.twig'));
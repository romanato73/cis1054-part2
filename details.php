<?php

include_once "app/Database.php";
require_once __DIR__."/app/bootstrap.php";

$dishes = App\Database::table('dishes')->get();
$item = [];

if (!isset($_GET['dish'])) {
    exit($twig->render('404.twig'));
}

foreach ($dishes as $dish) {
    if ($dish->id == $_GET['dish']) {
        $item = $dish;
        break;
    }
}

if (empty($item)){
    exit($twig->render('404.twig'));
}

echo $twig->render('details.twig', ['dish' => $item]);

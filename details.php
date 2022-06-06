<?php

include_once "app/Database.php";
require_once __DIR__."/app/bootstrap.php";

$dishes = App\Database::table('dishes')->get();
$item = [];

if (!isset($_GET['dish'])) {
    exit("Not found");
}

foreach ($dishes as $dish) {
    if ($dish->id == $_GET['dish']) {
        $item = $dish;
        break;
    }
}

if (empty($item)){
    exit("Not found");
}

echo $twig->render('details.twig', ['dish' => $item]);

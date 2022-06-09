<?php

use App\Database;
use App\FavouriteList;

require_once __DIR__."/app/bootstrap.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['dish_id'])) {
        header("Location: /details.php?dish=".$_POST['dish_id']);
    }

    // Get the dish from database
    $dish = Database::table('dishes')->get($_POST['dish_id']);

    // Check if dish exists
    if (!$dish) {
        exit($twig->render('404.twig', ['message' => 'Dish with this ID does not exist.']));
    }

    // Store/Remove new dish into favourites
    FavouriteList::storeOrRemove($_POST['dish_id']);

    if ($_POST['from'] === 'menu') {
        header("Location: /menu.php#".$_POST['category']);
    } else if ($_POST['from'] === 'details') {
        header("Location: /details.php?dish=".$_POST['dish_id']);
    } else {
        header("Location: /favourites.php");
    }
}

$favourites = [];

foreach (App\Database::table('categories')->get() as $category) {
    $dishes = Database::table('dishes')
        ->where('category_id', '==', $category->id)
        ->get(FavouriteList::get());

    if (empty($dishes)) {
        continue;
    }

    $favourites[] = [
        'category' => $category,
        'dishes' => $dishes,
    ];
}

echo $twig->render('favourites.twig', ['favourites' => $favourites]);
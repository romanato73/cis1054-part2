<?php

use App\Database;
use App\FavouritesStorage;

require_once __DIR__."/app/bootstrap.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the dish from database
    $dish = Database::table('dishes')->get($_POST['dish_id']);

    // Check if dish exists
    if (!$dish) {
        exit('Dish with this ID does not exist.');
    }

    // Store new dish into favourites
    FavouritesStorage::store($_POST['dish_id']);
}

$favourites = [];

foreach (App\Database::table('categories')->get() as $category) {
    $dishes = Database::table('dishes')
        ->where('category_id', '==', $category->id)
        ->get(FavouritesStorage::get());

    if (empty($dishes)) {
        continue;
    }

    $favourites[] = [
        'category' => $category,
        'dishes' => $dishes,
    ];
}

echo $twig->render('favourites.twig', ['favourites' => $favourites]);
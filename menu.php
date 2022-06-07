<?php

include_once __DIR__."/app/bootstrap.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // save the id of dish into cookies
    // redirect to the same page but with get request
}

$food = [];

if (isset($_GET['category'])) {
    foreach (App\Database::table('categories')->get() as $category) {
        if ($category->name !== $_GET['category']) {
            continue;
        }

        $dishes = \App\Database::table('dishes')
            ->where('category_id', '==', $category->id)
            ->get();

        $food[] = [
            'category' => $category,
            'dishes' => $dishes,
        ];
    }
} else {
    foreach (App\Database::table('categories')->get() as $category) {
        $dishes = \App\Database::table('dishes')
            ->where('category_id', '==', $category->id)
            ->get();

        $food[] = [
            'category' => $category,
            'dishes' => $dishes,
        ];
    }
}
echo $twig->render('menu.twig', ['food' => $food]);
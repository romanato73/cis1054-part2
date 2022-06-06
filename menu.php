<?php

include_once __DIR__."/app/bootstrap.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // save the id of dish into cookies
    // redirect to the same page but with get request
}

$food = [];

if (isset($_GET['category'])) {
    $list = App\Database::table('dishes')->get();

    foreach ($list as $dish) {
        if (strtolower($dish->category) == strtolower($_GET['category'])) {
            $food = $list;
        }
    }

    if (empty($food)) {
        exit("Not found");
    }

    echo $twig->render('menu.twig', ['food' => $food]);

} else {
    exit('Not found');
}
<?php

include_once "helpers/Database.php";

session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Restaurant</title>
    <link rel="stylesheet" href="/css/favourites.css">
    <link rel="stylesheet" href="/lib/fontawesome/css/all.min.css">
</head>
<body>

<header>
    <nav class="navbar container">
        <a href="/" class="navbar-logo">
            <i class="fas fa-bowl-rice"></i>
            Restaurant
        </a>
        <div class="nav">
            <?php foreach (Database::table('categories')->get() as $category) { ?>
                <a href="/<?= $category->id ?>" class="nav-link"><?= $category->name ?></a>
            <?php } ?>
            <a href="/favourites.php" class="nav-link">
                <i class="far fa-heart"></i>
            </a>
        </div>
    </nav>
</header>

<main class="container">
    <?php

    $favoriteIds = array_unique(array_map(static function () {
        return rand(1, count(Database::table('dishes')->get()) - 1);
    }, array_fill(0, 10, null)));

    $dishes = Database::table('dishes');

    foreach (Database::table('categories')->get() as $category) {
        $dishes = Database::table('dishes')
            ->where('category_id', '==', $category->id)
            ->get($favoriteIds);

        if (count($dishes) === 0) {
            continue;
        }
        ?>
        <div class="category">
            <h1 class="category-title"><?= $category->name ?></h1>
            <?php
            if (!empty($category->description)) { ?>
                <div class="category-description"><?= $category->description ?></div>
            <?php } ?>
        </div>

        <div class="dishes">
            <?php foreach ($dishes as $dish) { ?>
                <a href="#" class="dish">
                    <div class="dish-header">
                        <div class="dish-name"><?= $dish->name ?></div>
                    </div>
                    <div class="dish-body">
                        <div class="dish-description">
                            <?=
                            strlen($dish->description) > 12
                                ? substr($dish->description, 0, 30) . '...'
                                : $dish->description
                            ?>
                        </div>
                        <button type="button" class="dish-favorite fav">
                            <i class="fas fa-heart fa-2xl"></i>
                        </button>
                    </div>
                </a>
            <?php } ?>
        </div>
    <?php } ?>
</main>

</body>
</html>
<?php

use App\Database;

include_once __DIR__."/app/bootstrap.php";

$menu = [];

if (isset($_GET['category'])) {
    foreach (Database::table('categories')->get() as $category) {
        if (strtolower($category->name) !== strtolower($_GET['category'])) {
            continue;
        }

        $dishes = Database::table('dishes')
            ->where('category_id', '==', $category->id)
            ->get();

        $menu[] = [
            'category' => $category,
            'dishes' => $dishes,
        ];

        break;
    }

    if (empty($menu)) {
        exit($twig->render('404.twig'));
    }
} else {
    foreach (Database::table('categories')->get() as $category) {
        $dishes = Database::table('dishes')
            ->where('category_id', '==', $category->id)
            ->get();

        $menu[] = [
            'category' => $category,
            'dishes' => $dishes,
        ];
    }
}

echo $twig->render('menu.twig', ['menu' => $menu]);
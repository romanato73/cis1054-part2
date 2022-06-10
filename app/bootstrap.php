<?php

// Include autoload
require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../utils.php';

// Start the session
session_start();

// Initialize twig loader
$twigLoader = new \Twig\Loader\FilesystemLoader([
    __DIR__."/../templates",
]);

// Initialize twig environment
$twig = new \Twig\Environment($twigLoader, [
    'cache' => __DIR__.'/../storage/cache/templates',
]);

// Set global variables
$twig->addGlobal('__menuCategories', \App\Database::table('categories')->get());
$twig->addGlobal('__currentCategory', $_GET['category'] ?? false);
$twig->addGlobal('__footerCurrentYear', (new DateTime())->format('Y'));
$twig->addGlobal('__favourites', \App\FavouriteList::get());
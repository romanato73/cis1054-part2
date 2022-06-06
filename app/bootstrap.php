<?php

// Include autoload
require_once __DIR__.'/../vendor/autoload.php';

// Start the session
session_start();

// Initialize twig loader
$twigLoader = new \Twig\Loader\FilesystemLoader([
    __DIR__."/../templates",
]);

// Initialize twig environment
$twig = new \Twig\Environment($twigLoader, [
    'debug' => true,
//    'cache' => __DIR__.'/../storage/cache/templates'
]);

// TODO: FOR DEBUGGING -> REMOVE
$twig->addExtension(new \Twig\Extension\DebugExtension());

// Set global variables
$twig->addGlobal('__menuCategories', \App\Database::table('categories')->get());
$twig->addGlobal('__footerCurrentYear', (new DateTime())->format('Y'));
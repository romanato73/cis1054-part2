<?php

if (php_sapi_name() !== "cli") {
    exit("Access denied - access script via CLI");
}

if ($argc === 2 && $argv[1] === "clear-cache") {
    $paths = [
        __DIR__ . "/storage/cache/favourites/",
        __DIR__ . "/storage/cache/templates/",
    ];

    echo "Clearing cache...".PHP_EOL;

    foreach ($paths as $path) {
        $it = new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS);

        echo "Checking directory: $path".PHP_EOL;

        $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);

        foreach ($files as $file) {
            if ($file->isFile() && basename($file) !== ".gitkeep") {
                echo "Deleting file: ".basename($file).PHP_EOL;
                unlink($file->getRealPath());
            } else if ($file->isDir()) {
                echo "Deleting directory: ".basename($file).PHP_EOL;
                rmdir($file->getRealPath());
            }
        }
    }

    exit("Cache cleared".PHP_EOL);
}

$message = "Usage: $argv[0] <command>".PHP_EOL;
$message .= "Commands:".PHP_EOL;
$message .= "\tclear-cache\tClears cache.".PHP_EOL;

exit($message);
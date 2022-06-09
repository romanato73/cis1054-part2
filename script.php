<?php

if (php_sapi_name() !== "cli") {
    exit("Access denied - access script via CLI");
}

if ($argc === 2 && $argv[1] === "clear-cache") {
    $paths = [
        __DIR__ . "/storage/cache/favourites",
        __DIR__ . "/storage/cache/templates",
    ];

    echo "Clearing cache...".PHP_EOL;

    foreach ($paths as $path) {
        $files = glob($path . "/*.{php,html}", GLOB_BRACE);
        echo "Directory: $path".PHP_EOL;
        foreach($files as $file){
            if(is_file($file)) {
                echo "Deleting file: ".basename($file).PHP_EOL;
                unlink($file);
            }
        }
    }

    exit("Cache cleared".PHP_EOL);
}

$message = "Usage: $argv[0] <command>".PHP_EOL;
$message .= "Commands:".PHP_EOL;
$message .= "\tclear-cache\tClears cache.".PHP_EOL;

exit($message);
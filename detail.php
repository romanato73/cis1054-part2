<?php

include_once "helpers/Database.php";

$dishes = Database::table('dishes')->get();
$item = [];

if (!isset($_GET['dish'])) {
    exit("Not found");
}

foreach ($dishes as $dish) {
    if ($dish->id == $_GET['dish']) {
        $item = $dish;
        break;
    }
}

if (empty($item)){
    exit("Not found");
}

?>

<a href = "/menu" > Back</a><br>
<?= $item->name ?> <br>
<?= $item->price ?? 0 ?> <br>
<?= $item->description ?> <br>
<?= $item->options ?>

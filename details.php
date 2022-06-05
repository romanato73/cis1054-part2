<?php 

$dishes = Database::table('dishes');
$item = [];

if (isset($_GET['dish'])) {
    foreach ($dishes as $dish) {
        if ($dish->id == $_GET['dish']) {
            $item = $dish;
            break; 
     }
    }



if (empty($item)){
    exit ("Not found");
}

?>

<a href = "/menu" > Back</a><br>
<?= $item-> name ?> <br>
<?= $item-> price ?> <br>
<?= $item-> description ?> <br>
Ingredients <br>
<?= $item-> options ?> <br>

<?php
}
?>

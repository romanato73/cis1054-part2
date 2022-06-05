<?php
session_start();
include_once "helpers/Database.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant</title>
    <link rel="stylesheet" href="/css/favourites.css">
    <link rel="stylesheet" href="/lib/fontawesome/css/all.min.css">
</head>

<body>
        <?php
        $food = [];

        if (isset($_GET['category'])) {
            $list = Database::table('dishes')->get();

            foreach ($list as $dish) {
                if ($dish->category == $_GET['category']) {
                    $food = $list;
                }
            }

            if (empty($food)) {
                exit("Not found");
            }
 
        foreach($food as $list){
            echo $list->name;
        }
    }else {
        exit('Not found');
    }
        ?>
</body>

</html>

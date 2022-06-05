<?php

require_once __DIR__.'/Database.php';

$database = new Database();

$food = $database -> get("SELECT id, name FROM type order by category");
?>

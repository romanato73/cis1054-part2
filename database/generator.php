<?php

$file = file_get_contents('text.txt');

$rows = explode("\n", $file);

$dishes = [];
$categories = [];

$dishId = 1;
$categoryId = 1;

$dish = [];

foreach ($rows as $row) {
    if (empty($row)) {
        continue;
    }

    if (str_starts_with($row, '--')) {
        if (!empty($dish)) {
            $dishes[] = $dish;
            $dish = [];
            $dishId++;
        }

        $categories[] = [
            'id' => $categoryId,
            'name' => ucfirst(substr($row, 2)),
            'description' => '',
        ];

        $categoryId++;

        continue;
    }

    if (str_starts_with($row, '-')) {
        if (!empty($dish)) {
            $dishes[] = $dish;
            $dish = [];
            $dishId++;
        } else {
            $dish = [
                'id' => $dishId,
                'category_id' => $categories[array_key_last($categories)]['id'],
                'category' => $categories[array_key_last($categories)]['name'],
                'name' => ucfirst(substr($row, 1)),
                'description' => '',
                'options' => '',
            ];
        }

        continue;
    }

    if (!empty($dish) && str_starts_with($row, '.')) {
        $dish['options'] .= ucfirst(substr($row, 1));;
        continue;
    }

    if (!empty($dish)) {
        $dish['description'] .= $row;
    }
}

if (!empty($categories)) file_put_contents('categories.json', json_encode($categories, JSON_PRETTY_PRINT));
if (!empty($dishes)) file_put_contents('dishes.json', json_encode($dishes, JSON_PRETTY_PRINT));
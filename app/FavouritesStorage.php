<?php

namespace App;

class FavouritesStorage
{
    /**
     * @var string Name of the cookie.
     */
    private static string $name = "favourites";

    /**
     * Store new dish into favourites.
     *
     * @param  int  $dishId
     * @return void
     */
    public static function store(int $dishId): void
    {
        $storage = $_COOKIE[self::$name] ?? [];

        $storage[] = $dishId;

        self::save($storage);
    }

    /**
     * Get favourites list.
     *
     * @return array
     */
    public static function get(): array
    {
        return $_COOKIE[self::$name] ?? [];
    }

    /**
     * Remove dish from favourites list.
     *
     * @param  int  $dishId
     * @return void
     */
    public static function remove(int $dishId): void
    {
        $storage = $_COOKIE[self::$name];

        foreach ($storage as $key => $item) {
            if ($item === $dishId) {
                unset($storage[$key]);
                break;
            }
        }

        self::save($storage);
    }

    /**
     * Set cookie.
     *
     * @param  array  $storage
     * @return void
     */
    private static function save(array $storage): void
    {
        setcookie(self::$name, $storage, time() + (86400 * 30));
    }
}
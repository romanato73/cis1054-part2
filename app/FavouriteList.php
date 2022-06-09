<?php

namespace App;

class FavouriteList
{
    /**
     * @var string Name of the cookie.
     */
    private static string $name = "favourites";

    /**
     * Generates the file with list.
     *
     * @return string
     */
    public static function generateFile(): string
    {
        $path = __DIR__ . "/../storage/cache/favourites/";
        $path .= uniqid('list_', true) . ".html";

        $content = "";

        foreach (self::get() as $dishId) {
            $dish = \App\Database::table('dishes')->get($dishId);

            $img = self::generateUri($dish->image);
            $link = self::generateUri("details.php?dish=$dish->id");

            $content .= "<a href='$link' style='display:block;margin-bottom:8px;' target='_blank'>";
            $content .= "<img src='$img' alt='$dish->name' style='max-width:100px;' />";
            $content .= "<h1 style='margin:8px 0;'>$dish->name</h1>";
            $content .= "</a>";
        }

        file_put_contents($path, $content);

        return $path;
    }

    /**
     * Store new dish into favourites.
     *
     * @param  int  $dishId
     * @return void
     */
    public static function storeOrRemove(int $dishId): void
    {
        if (self::has($dishId)) {
            self::remove($dishId);
        } else {
            self::store($dishId);
        }
    }

    /**
     * Get favourites list.
     *
     * @return array
     */
    public static function get(): array
    {
        return isset($_COOKIE[self::$name]) ? json_decode($_COOKIE[self::$name], true) : [];
    }

    public static function has(string $dishId): bool
    {
        $storage = self::get();

        foreach ($storage as $item) {
            if ($item == $dishId) {
                return true;
            }
        }

        return false;
    }

    public static function store(int $dishId): void
    {
        $storage = self::get();

        $storage[] = $dishId;

        self::save($storage);
    }

    /**
     * Remove dish from favourites list.
     *
     * @param  int  $dishId
     * @return void
     */
    public static function remove(int $dishId): void
    {
        $storage = self::get();

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
        setcookie(self::$name, json_encode($storage), time() + (86400 * 30));
    }

    private static function generateUri(string $append): string
    {
        $uri = "http://";
        $uri .= $_SERVER['SERVER_NAME'];
        $uri .= ":" . $_SERVER['SERVER_PORT'];
        $uri .= "/" . $append;

        return $uri;
    }
}
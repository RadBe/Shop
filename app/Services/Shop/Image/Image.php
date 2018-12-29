<?php


namespace App\Services\Shop\Image;


class Image
{
    public const DIR = 'img/shop/items';

    public static function filterName(string $name): string
    {
        return str_replace(':', '_', $name);
    }
}
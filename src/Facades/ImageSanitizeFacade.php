<?php

namespace LaravelAt\ImageSanitize\Facades;

use Illuminate\Support\Facades\Facade;
use LaravelAt\ImageSanitize\ImageSanitize;

/**
 * @see \LaravelAt\ImageSanitize\ImageSanitize
 */
class ImageSanitizeFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ImageSanitize::class;
    }
}

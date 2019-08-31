<?php

namespace LaravelAt\ImageSanitize\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \LaravelAt\ImageSanitize\ImageSanitize
 */
class ImageSanitizeFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'image-sanitize';
    }
}

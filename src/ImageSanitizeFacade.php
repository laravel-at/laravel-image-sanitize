<?php

namespace LaravelAt\ImageSanitize;

use Illuminate\Support\Facades\Facade;

/**
 * @see \LaravelAt\ImageSanitize\ImageSanitizeClass
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
        return 'ImageSanitize';
    }
}

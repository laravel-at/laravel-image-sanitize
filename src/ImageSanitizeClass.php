<?php

namespace LaravelAt\ImageSanitize;

class ImageSanitizeClass
{
    /**
     * Create a new Skeleton Instance.
     */
    public function __construct()
    {
        // constructor body
    }

    public static function handle($request)
    {
        $files = $request->allFiles();

        if(! $files) {
            return $request;
        }

        foreach ($files as $file) {
            //check if its an image
            // if so compress
            // and replace request
        }

        return $request;
    }
}

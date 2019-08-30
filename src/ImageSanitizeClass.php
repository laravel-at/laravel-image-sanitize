<?php

namespace LaravelAt\ImageSanitize;

class ImageSanitizeClass
{
    protected $rules = ['<?php', 'phar'];

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

    public function detect(string $string) : bool
    {
        foreach($this->rules as $rule)
        {
            if(strpos($string, $rule) !== false)
            {
                return true;
            }
        }

        return false;
    }
}

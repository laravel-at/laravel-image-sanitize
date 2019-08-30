<?php

namespace LaravelAt\ImageSanitize;

class ImageSanitizeClass
{
    protected $rules = [
        '<?php',
        'phar'
    ];

    protected $imageMimeTypes = [
        'image/jpeg',
        'image/gif',
        'image/png',
        'image/bmp',
        'image/svg+xml',
    ];

    /**
     * Create a new Skeleton Instance.
     */
    public function __construct()
    {
        // constructor body
    }

    public function handle($request)
    {
        $files = $request->allFiles();

        if(! $files) {
            return $request;
        }

        $images = array_filter($files, function($file) {
           return in_array(mime_content_type($file->getPathname()), $this->imageMimeTypes);
        });

        foreach($images as $image){
            // compress
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

<?php

namespace LaravelAt\ImageSanitize;

class ImageSanitizeClass
{
    protected $imageMimeTypes = [
        'image/jpeg',
        'image/gif',
        'image/png',
        'image/bmp',
        'image/svg+xml',
    ];

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
}

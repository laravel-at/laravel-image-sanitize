<?php

namespace LaravelAt\ImageSanitize;

use Intervention\Image\ImageManagerStatic as Image;

class ImageSanitize
{
    protected $forbiddenPatterns = [
        '<?php',
        'phar',
    ];

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

        if (! $files) {
            return $request;
        }

        /** @var \Illuminate\Http\UploadedFile $image */
        foreach($this->getImages($files) as $image){
            // compress
            // and replace request
        }

        return $request;
    }

    public function detect(string $content): bool
    {
        foreach ($this->forbiddenPatterns as $forbiddenPattern) {
            if (strpos($content, $forbiddenPattern) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $files
     * @return array
     */
    public function getImages($files): array
    {
        return array_filter($files, function ($file) {
            return in_array(mime_content_type($file->getPathname()), $this->imageMimeTypes);
        });
    }

    public function sanitize(string $content)
    {
        return Image::make($content)->encode();
    }
}

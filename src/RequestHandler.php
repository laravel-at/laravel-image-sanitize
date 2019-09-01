<?php

namespace LaravelAt\ImageSanitize;

use Illuminate\Http\UploadedFile;
use LaravelAt\ImageSanitize\Lists\MimeTypeList;

class RequestHandler
{
    /**
     * @var MimeTypeList
     */
    protected $mimeTypeList;

    public function __construct(MimeTypeList $mimeTypeList)
    {
        $this->mimeTypeList = $mimeTypeList;
    }

    public function handle($request): void
    {
        /** @var UploadedFile $file */
        foreach ($this->getMaliciousImages($request->allFiles()) as $file) {
            file_put_contents($file->getPathname(), app(ImageSanitize::class)->sanitize($file->get()));
        }
    }

    public function getMaliciousImages($files): array
    {
        return array_filter($this->getImages($files), function (UploadedFile $file) {
            return app(ImageSanitize::class)->detect($file->get());
        });
    }

    /**
     * @param $files
     * @return array
     */
    public function getImages($files): array
    {
        return array_filter($files, function (UploadedFile $file) {
            return in_array(mime_content_type($file->getPathname()), $this->mimeTypeList->get());
        });
    }
}

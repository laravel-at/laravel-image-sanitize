<?php

namespace LaravelAt\ImageSanitize;

use Illuminate\Http\UploadedFile;
use LaravelAt\ImageSanitize\Lists\MimeTypeList;

class RequestHandler
{
    /**
     * @var \LaravelAt\ImageSanitize\ImageSanitize
     */
    protected $imageSanitize;

    /**
     * @var MimeTypeList
     */
    protected $mimeTypeList;

    public function __construct(ImageSanitize $imageSanitize, MimeTypeList $mimeTypeList)
    {
        $this->imageSanitize = $imageSanitize;
        $this->mimeTypeList = $mimeTypeList;
    }

    /**
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function handle($request): void
    {
        foreach ($this->getMaliciousImages($request->allFiles()) as $file) {
            file_put_contents($file->getPathname(), $this->imageSanitize->sanitize($file->get()));
        }
    }

    /**
     * @param  array|UploadedFile[] $files
     * @return array
     */
    public function getMaliciousImages(array $files): array
    {
        return array_filter($this->getImages($files), function (UploadedFile $file) {
            return $this->imageSanitize->detect($file->get());
        });
    }

    /**
     * @param  array|UploadedFile[] $files
     * @return array
     */
    public function getImages(array $files): array
    {
        return array_filter($files, function (UploadedFile $file) {
            return in_array(mime_content_type($file->getPathname()), $this->mimeTypeList->get());
        });
    }
}

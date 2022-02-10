<?php

namespace LaravelAt\ImageSanitize;

use Illuminate\Http\UploadedFile;
use Illuminate\Http\Reques;
use Illuminate\Support\Arr;
use LaravelAt\ImageSanitize\Lists\MimeTypeList;

class RequestHandler
{

    public function __construct(
        protected ImageSanitize $imageSanitize,
        protected MimeTypeList $mimeTypeList,
    ) {}

    public function handle(Request $request): void
    {
        foreach ($this->getMaliciousImages($request->allFiles()) as $file) {
            file_put_contents($file->getPathname(), $this->imageSanitize->sanitize($file->get()));
        }
    }

    public function getMaliciousImages(array $files): array
    {
        if (! Arr::first($files) instanceof UploadedFile) {
            $files = collect($files)->flatten()->toArray();
        }

        return array_filter($this->getImages($files), function (UploadedFile $file) {
            return $this->imageSanitize->detect($file->get());
        });
    }

    public function getImages(array $files): array
    {
        return array_filter($files, function (UploadedFile $file) {
            return in_array(mime_content_type($file->getPathname()), $this->mimeTypeList->get());
        });
    }
}

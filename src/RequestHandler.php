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

    public function handle($request)
    {
        $files = $request->allFiles();

        if (!$files) {
            return $request;
        }

        /** @var UploadedFile $image */
        foreach ($this->getImages($files) as $image) {
            // compress
            // and replace request
        }

        return $request;
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

<?php


namespace LaravelAt\ImageSanitize;


use Illuminate\Http\UploadedFile;
use LaravelAt\ImageSanitize\Lists\PatternList;
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
            file_put_contents($file->getPathname(),(new ImageSanitize(new PatternList()))->sanitize($file->get()));
        }
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

    public function getMaliciousImages($files): array
    {
        return array_filter($this->getImages($files), function (UploadedFile $file) {
            return (new ImageSanitize(new PatternList()))->detect($file->get());
        });
    }
}

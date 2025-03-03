<?php

namespace LaravelAt\ImageSanitize;

use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\EncodedImage;
use Intervention\Image\Encoders\AutoEncoder;
use Intervention\Image\ImageManager;
use LaravelAt\ImageSanitize\Lists\PatternList;

class ImageSanitize
{
    public function __construct(
        protected PatternList $patternList,
    ) {}

    public function detect(string $content): bool
    {
        foreach ($this->patternList->get() as $forbiddenPattern) {
            if (strpos($content, $forbiddenPattern) !== false) {
                return true;
            }
        }

        return false;
    }

    public function sanitize(string $content): EncodedImage
    {
        $imageManager = new ImageManager(new Driver());

        $image = $imageManager->read($content);

        return $image->encode(new AutoEncoder(quality: 100));
    }
}

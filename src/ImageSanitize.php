<?php

namespace LaravelAt\ImageSanitize;

use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use LaravelAt\ImageSanitize\Lists\PatternList;

class ImageSanitize
{
    public function __construct(
        protected ImageManager $imageManager,
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

    public function sanitize(string $content): Image
    {
        return $this->imageManager->make($content)->encode(null, 100);
    }
}

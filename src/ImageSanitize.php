<?php

namespace LaravelAt\ImageSanitize;

use LaravelAt\ImageSanitize\Lists\PatternList;
use Intervention\Image\ImageManagerStatic as Image;

class ImageSanitize
{
    /**
     * @var PatternList
     */
    private $patternList;

    public function __construct(PatternList $patternList)
    {
        $this->patternList = $patternList;
    }

    public function detect(string $content): bool
    {
        foreach ($this->patternList->get() as $forbiddenPattern) {
            if (strpos($content, $forbiddenPattern) !== false) {
                return true;
            }
        }

        return false;
    }

    public function sanitize(string $content)
    {
        return Image::make($content)->encode();
    }
}
